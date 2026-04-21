<?php

namespace App\Http\Controllers;

use App\Models\Gateway;
use App\Models\Plan;
use Illuminate\Http\Request;

class MembershipController extends Controller
{
    public function index(){

        $plan = Plan::get();
        $gateway = Gateway::first();
        return view("user-view.memberships.index", compact("plan", "gateway"));
    }
}
