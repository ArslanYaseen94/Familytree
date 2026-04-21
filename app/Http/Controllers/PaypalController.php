<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class PaypalController extends Controller
{
    public function subscribe($id)
    {
        $plan = Plan::findOrFail($id);

        $response = Http::asForm()->post(config('services.paypal.endpoint'), [
            'METHOD' => 'SetExpressCheckout',
            'VERSION' => '204.0',
            'USER' => config('services.paypal.username'),
            'PWD' => config('services.paypal.password'),
            'SIGNATURE' => config('services.paypal.signature'),

            // SetExpressCheckout params
            'PAYMENTREQUEST_0_PAYMENTACTION' => 'Sale',
            'L_BILLINGTYPE0' => 'RecurringPayments',
            'L_BILLINGAGREEMENTDESCRIPTION0' => $plan->name . ' Subscription',
            // PayPal NVP expects uppercase keys; keep the old ones too (some gateways are picky)
            'CANCELURL' => route('paypal.cancel'),
            'RETURNURL' => route('paypal.success', ['plan_id' => $plan->id]),
            'cancelUrl' => route('paypal.cancel'),
            'returnUrl' => route('paypal.success', ['plan_id' => $plan->id]),
        ]);

        parse_str($response->body(), $parsed);

        $ack = $parsed['ACK'] ?? null;
        if ($ack === 'Success' || $ack === 'SuccessWithWarning') {
            return redirect(config('services.paypal.redirect') . $parsed['TOKEN']);
        }

        return back()->with('error', $parsed['L_LONGMESSAGE0'] ?? 'Something went wrong with PayPal.');
    }

    public function success(Request $request)
    {
        $token = $request->get('token');
        $payerID = $request->get('PayerID');
        $planId = $request->get('plan_id');

        // Get the plan and authenticated user
        $plan = \App\Models\Plan::findOrFail($planId);
        $user = auth()->user();

        // Set start and end dates
        $startDate = now();
        $endDate = now()->addMonth();

        // Create entry in tbl_order
        DB::table('tbl_order')->insert([
            'user_id' => $user->id,
            'plan_id' => $planId,
            'package_start' => $startDate,
            'package_end' => $endDate,
            "is_active"=>1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Update user membership_plan in tbl_user
        DB::table('tbl_user')
            ->where('id', $user->id)
            ->update(['membership_plan' => $plan->name]);
        return redirect()->route('user.dashboard')
        ->with(__('messages.success'), __('messages.Subscription successful.'));

    }


    public function cancel()
    {
        return 'Subscription Cancelled by User.';
    }
}
