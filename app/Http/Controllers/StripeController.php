<?php

namespace App\Http\Controllers;

use App\Models\Gateway;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class StripeController extends Controller
{
    private const MAX_RETRIES = 3;
    private const TIMEOUT = 30;

    /**
     * Create Stripe checkout session and redirect to Stripe's hosted checkout
     */
    public function checkout($id)
    {
        $plan = Plan::findOrFail($id);
        $user = auth()->user();

        $gateway = Gateway::first();
        // Prefer env secret, fallback to DB; env() may be set but empty.
        $stripeSecret = trim((string) env('STRIPE_SECRET', ''));
        if ($stripeSecret === '' && $gateway && $gateway->stripe_api_key) {
            $stripeSecret = trim((string) $gateway->stripe_api_key);
        }

        if ($stripeSecret === '') {
            return back()->with('error', 'Stripe secret key is not configured.');
        }
        // Guard against accidentally using publishable key (pk_) instead of secret (sk_)
        if (str_starts_with($stripeSecret, 'pk_')) {
            return back()->with('error', 'Stripe secret key is invalid (you entered a publishable key). Please set a key that starts with sk_.');
        }

        $amountCents = (int) round(((float) $plan->monthly_price) * 100);
        if ($amountCents < 50) {
            return back()->with('error', 'Invalid plan amount.');
        }

        // URLs for after payment
        // Include the Stripe session id so we can finalize membership immediately on return.
        $successUrl = route('stripe.success') . '?session_id={CHECKOUT_SESSION_ID}';
        $cancelUrl = route('stripe.cancel');

        $payload = [
            'mode' => 'payment',
            'success_url' => $successUrl,
            'cancel_url' => $cancelUrl,
            'customer_email' => $user?->email,
            'client_reference_id' => (string) $user?->id,
            'metadata[plan_id]' => (string) $plan->id,
            'metadata[user_id]' => (string) $user?->id,
            'line_items[0][quantity]' => 1,
            'line_items[0][price_data][currency]' => 'usd',
            'line_items[0][price_data][unit_amount]' => $amountCents,
            'line_items[0][price_data][product_data][name]' => $plan->name . ' Subscription',
        ];

        $response = $this->makeStripeRequest('POST', 'https://api.stripe.com/v1/checkout/sessions', $stripeSecret, $payload);

        if (!$response['success']) {
            return back()->with('error', $response['error'] ?? 'Failed to start Stripe checkout.');
        }

        $data = $response['data'];
        if (!isset($data['url'])) {
            return back()->with('error', 'Stripe checkout URL missing.');
        }

        // Redirect to Stripe's hosted checkout page
        return redirect()->away($data['url']);
    }

    /**
     * Handle Stripe webhook events (payment confirmation)
     */
    public function webhook(Request $request)
    {
        $gateway = Gateway::first();
        $stripeWebhookSecret = env('STRIPE_WEBHOOK_SECRET', $gateway ? $gateway->stripe_webhook_secret : null);

        if (!$stripeWebhookSecret) {
            Log::error('Stripe webhook secret not configured');
            return response()->json(['error' => 'Webhook secret not configured'], 400);
        }

        $payload = $request->getContent();
        $signature = $request->header('Stripe-Signature');

        // Verify webhook signature
        if (!$this->verifyStripeSignature($payload, $signature, $stripeWebhookSecret)) {
            Log::warning('Invalid Stripe webhook signature');
            return response()->json(['error' => 'Invalid signature'], 401);
        }

        $event = json_decode($payload, true);

        // Handle checkout.session.completed event
        if ($event['type'] === 'checkout.session.completed') {
            $session = $event['data']['object'];
            $this->handleCheckoutSessionCompleted($session);
        }

        return response()->json(['success' => true], 200);
    }

    /**
     * Process completed checkout session from webhook
     */
    private function handleCheckoutSessionCompleted($session)
    {
        $planId = $session['metadata']['plan_id'] ?? null;
        $userId = $session['metadata']['user_id'] ?? null;
        $paymentStatus = $session['payment_status'] ?? null;

        if (!$planId || !$userId || $paymentStatus !== 'paid') {
            Log::warning('Invalid session data', ['session' => $session]);
            return;
        }

        // Check if order already exists (prevent duplicates)
        $existing = DB::table('tbl_order')
            ->where('user_id', $userId)
            ->where('plan_id', $planId)
            ->where('stripe_session_id', $session['id'])
            ->first();

        if ($existing) {
            Log::info('Order already exists for session: ' . $session['id']);
            return;
        }

        $plan = Plan::find($planId);
        if (!$plan) {
            Log::error('Plan not found', ['plan_id' => $planId]);
            return;
        }

        $startDate = now();
        $endDate = now()->addMonth();

        try {
            // Insert order record
            DB::table('tbl_order')->insert([
                'user_id' => $userId,
                'plan_id' => $planId,
                'package_start' => $startDate,
                'package_end' => $endDate,
                'is_active' => 1,
                'stripe_session_id' => $session['id'],
                'stripe_customer_id' => $session['customer'] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Update user membership
            DB::table('tbl_user')
                ->where('id', $userId)
                ->update([
                    'membership_plan' => $plan->name,
                    'updated_at' => now(),
                ]);

            Log::info('Membership activated via webhook', ['user_id' => $userId, 'plan_id' => $planId]);
        } catch (\Exception $e) {
            Log::error('Error processing webhook', ['error' => $e->getMessage()]);
        }
    }

    /**
     * Verify Stripe webhook signature
     */
    private function verifyStripeSignature($payload, $signature, $secret)
    {
        try {
            $signedContent = explode(',', $signature);
            $timestamp = null;
            $receivedSignature = null;

            foreach ($signedContent as $item) {
                $parts = explode('=', $item);
                if ($parts[0] === 't') {
                    $timestamp = $parts[1];
                }
                if ($parts[0] === 'v1') {
                    $receivedSignature = $parts[1];
                }
            }

            if (!$timestamp || !$receivedSignature) {
                return false;
            }

            $signedContent = $timestamp . '.' . $payload;
            $hash = hash_hmac('sha256', $signedContent, $secret);

            return hash_equals($hash, $receivedSignature);
        } catch (\Exception $e) {
            Log::error('Error verifying webhook signature: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Make HTTP request to Stripe API with retry logic
     */
    private function makeStripeRequest($method, $url, $stripeSecret, $payload = [], $retry = 0)
    {
        try {
            $request = Http::asForm()
                ->withBasicAuth($stripeSecret, '')
                ->timeout(self::TIMEOUT)
                ->connectTimeout(self::TIMEOUT);

            if ($method === 'POST') {
                $response = $request->post($url, $payload);
            } else {
                $response = $request->get($url);
            }

            if ($response->successful()) {
                return ['success' => true, 'data' => $response->json()];
            }

            return ['success' => false, 'error' => 'Stripe API error: ' . $response->status()];
        } catch (\Exception $e) {
            // Retry on timeout or connection errors
            if ($retry < self::MAX_RETRIES && $this->isRetryableError($e)) {
                sleep(1 + $retry); // Exponential backoff
                return $this->makeStripeRequest($method, $url, $stripeSecret, $payload, $retry + 1);
            }

            return ['success' => false, 'error' => 'Connection error: ' . $e->getMessage()];
        }
    }

    /**
     * Check if error is retryable
     */
    private function isRetryableError(\Exception $e)
    {
        $message = $e->getMessage();
        return strpos($message, 'timeout') !== false ||
               strpos($message, 'SSL') !== false ||
               strpos($message, 'Connection') !== false;
    }

    /**
     * Success page after returning from Stripe checkout
     */
    public function success(Request $request)
    {
        $gateway = Gateway::first();
        $stripeSecret = trim((string) env('STRIPE_SECRET', ''));
        if ($stripeSecret === '' && $gateway && $gateway->stripe_api_key) {
            $stripeSecret = trim((string) $gateway->stripe_api_key);
        }

        $sessionId = (string) $request->query('session_id', '');
        if ($stripeSecret === '' || $sessionId === '') {
            // Fallback to "processing" if we can't verify
            return redirect()->route('user.dashboard')
                ->with('success', 'Payment is being processed. You will receive a confirmation email shortly.');
        }

        // Retrieve the Checkout Session and activate membership if paid
        $resp = $this->makeStripeRequest('GET', 'https://api.stripe.com/v1/checkout/sessions/' . urlencode($sessionId), $stripeSecret);
        if (!$resp['success']) {
            return redirect()->route('user.dashboard')
                ->with('success', 'Payment is being processed. You will receive a confirmation email shortly.');
        }

        $session = $resp['data'] ?? [];
        $planId = $session['metadata']['plan_id'] ?? null;
        $userId = $session['metadata']['user_id'] ?? null;
        $paymentStatus = $session['payment_status'] ?? null;

        if ($planId && $userId && $paymentStatus === 'paid') {
            $existing = DB::table('tbl_order')
                ->where('stripe_session_id', $sessionId)
                ->first();

            if (!$existing) {
                $plan = Plan::find($planId);
                if ($plan) {
                    $startDate = now();
                    $endDate = now()->addMonth();

                    DB::table('tbl_order')->insert([
                        'user_id' => $userId,
                        'plan_id' => $planId,
                        'package_start' => $startDate,
                        'package_end' => $endDate,
                        'is_active' => 1,
                        'stripe_session_id' => $sessionId,
                        'stripe_customer_id' => $session['customer'] ?? null,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                    DB::table('tbl_user')
                        ->where('id', $userId)
                        ->update([
                            'membership_plan' => $plan->name,
                            'updated_at' => now(),
                        ]);
                }
            }
        }

        return redirect()->route('user.dashboard')
            ->with('success', 'Payment successful. Your plan has been activated.');
    }

    /**
     * Cancel page if user cancels checkout
     */
    public function cancel()
    {
        return redirect()->route('user.memberships')->with('error', 'Payment cancelled. Please try again.');
    }
}

