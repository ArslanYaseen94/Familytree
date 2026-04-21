<?php

namespace App\Http\Controllers;

use App\Models\Gateway;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class StripeController extends Controller
{
    public function checkout($id)
    {
        $plan = Plan::findOrFail($id);
        $user = auth()->user();

        $gateway = Gateway::first();
        if (!$gateway || (string) $gateway->stripe_status !== '1' || !$gateway->stripe_api_key) {
            return back()->with('error', 'Stripe is not available right now.');
        }

        $amountCents = (int) round(((float) $plan->monthly_price) * 100);
        if ($amountCents < 50) {
            return back()->with('error', 'Invalid plan amount.');
        }

        $successUrl = route('stripe.success', ['plan_id' => $plan->id]) . '&session_id={CHECKOUT_SESSION_ID}';
        $cancelUrl = route('stripe.cancel');

        $response = Http::asForm()
            ->withBasicAuth($gateway->stripe_api_key, '')
            ->post('https://api.stripe.com/v1/checkout/sessions', [
                'mode' => 'payment',
                'success_url' => $successUrl,
                'cancel_url' => $cancelUrl,

                'customer_email' => $user?->email,
                'client_reference_id' => (string) $user?->id,

                'line_items[0][quantity]' => 1,
                'line_items[0][price_data][currency]' => 'usd',
                'line_items[0][price_data][unit_amount]' => $amountCents,
                'line_items[0][price_data][product_data][name]' => $plan->name . ' Subscription',
            ]);

        if (!$response->successful()) {
            return back()->with('error', 'Failed to start Stripe checkout.');
        }

        $data = $response->json();
        if (!isset($data['url'])) {
            return back()->with('error', 'Stripe checkout URL missing.');
        }

        return redirect()->away($data['url']);
    }

    public function success(Request $request)
    {
        $planId = $request->get('plan_id');
        $sessionId = $request->get('session_id');

        $plan = Plan::findOrFail($planId);
        $user = auth()->user();

        $gateway = Gateway::first();
        if (!$gateway || !$gateway->stripe_api_key) {
            return redirect()->route('user.memberships')->with('error', 'Stripe configuration missing.');
        }

        if (!$sessionId) {
            return redirect()->route('user.memberships')->with('error', 'Missing Stripe session.');
        }

        $sessionResp = Http::withBasicAuth($gateway->stripe_api_key, '')
            ->get('https://api.stripe.com/v1/checkout/sessions/' . $sessionId);

        if (!$sessionResp->successful()) {
            return redirect()->route('user.memberships')->with('error', 'Unable to verify payment.');
        }

        $session = $sessionResp->json();
        if (($session['payment_status'] ?? null) !== 'paid') {
            return redirect()->route('user.memberships')->with('error', 'Payment not completed.');
        }

        $startDate = now();
        $endDate = now()->addMonth();

        DB::table('tbl_order')->insert([
            'user_id' => $user->id,
            'plan_id' => $planId,
            'package_start' => $startDate,
            'package_end' => $endDate,
            'is_active' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('tbl_user')
            ->where('id', $user->id)
            ->update(['membership_plan' => $plan->name]);

        return redirect()->route('user.dashboard')
            ->with(__('messages.success'), __('messages.Subscription successful.'));
    }

    public function cancel()
    {
        return redirect()->route('user.memberships')->with('error', 'Payment cancelled.');
    }
}

