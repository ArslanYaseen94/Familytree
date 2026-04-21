<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\RecaptchaSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GeneralController extends Controller
{
    public function index()
    {

        $auth = Auth::guard("admin")->user();
        return view("admin-view.configuration.index", compact("auth"));
    }

    public function payments()
    {
        $gateway = DB::table('tbl_gateway')->first(); // Assuming only one row
        return view("admin-view.configuration.paymentgateway", compact("gateway"));
    }

    public function socialmedia()
    {
        return view("admin-view.configuration.socialmedia");
    }
    public function recaptcha()
    {
        $setting = RecaptchaSetting::first(); // assuming only one row
        return view("admin-view.configuration.recaptcha", compact("setting"));
    }
    public function update(Request $request)
    {
        $request->validate([
            'status' => 'required|boolean',
            'site_key' => 'required|string',
            'secret_key' => 'required|string',
        ]);

        $setting = RecaptchaSetting::first();

        if (!$setting) {
            $setting = new RecaptchaSetting();
        }

        $setting->status = $request->status;
        $setting->site_key = $request->site_key;
        $setting->secret_key = $request->secret_key;
        $setting->save();

        return redirect()->route('admin.recaptcha')
         ->with(__('messages.success'), __('messages.Settings updated successfully.'));
    }
    public function memberships()
    {
        $plan = Plan::get();
        return view("admin-view.configuration.memberships", compact("plan"));
    }

    public function security()
    {
        $auth = Auth::guard("admin")->user();
        return view("admin-view.configuration.security", compact("auth"));
    }
}
