<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GatewayController extends Controller
{
    private function getGatewayRow()
    {
        // Ensures there's always one row
        $gateway = DB::table('tbl_gateway')->first();
        if (!$gateway) {
            DB::table('tbl_gateway')->insert(['created_at' => now(), 'updated_at' => now()]);
        }
        return DB::table('tbl_gateway')->first();
    }

    public function updateCod(Request $request)
    {
        // dd($request->all());
        $status = $request->input('cod_status') === 'on' ? 1 : 0;
        $this->getGatewayRow();
        DB::table('tbl_gateway')->update(['cod_status' => $status, 'updated_at' => now()]);
        return back()
        ->with(__('messages.success'), __('messages.Cash on Delivery updated.'));
    }

    public function updateDigital(Request $request)
    {
        $status = $request->input('digital_status') === 'on' ? 1 : 0;
        $this->getGatewayRow();
        DB::table('tbl_gateway')->update(['digital_status' => $status, 'updated_at' => now()]);
        return back()
        ->with(__('messages.success'), __('messages.Digital Payment updated..'));
    }

    public function updatePaypal(Request $request)
    {
        $this->getGatewayRow();
        DB::table('tbl_gateway')->update([
            'paypal_status' => $request->has('paypal_status') ? 1 : 0,
            'paypal_client_id' => $request->input('paypal_client_id'),
            'paypal_secret' => $request->input('paypal_secret'),
            'updated_at' => now()
        ]);
        return back()
        ->with(__('messages.success'), __('messages.PayPal updated.'));
    }

    public function updateStripe(Request $request)
    {
        $this->getGatewayRow();
        DB::table('tbl_gateway')->update([
            'stripe_status' => $request->has('stripe_status') ? 1 : 0,
            'stripe_publish_key' => $request->input('stripe_publish_key'),
            'stripe_api_key' => $request->input('stripe_api_key'),
            'updated_at' => now()
        ]);
        return back()
        ->with(__('messages.success'), __('messages.Stripe updated.'));
    }
}
