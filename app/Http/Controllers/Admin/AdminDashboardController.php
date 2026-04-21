<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Messages;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Your admin dashboard logic here

        $orders = Order::count();
        $members = Member::count();
        $user = User::count();
        $messages = Messages::where("sender_id", "!=", 0)->count();
        $freeusers = User::where("membership_plan", "Free")->count();
        $standardusers = User::where("membership_plan", "standard")->count();
        $silverusers = User::where("membership_plan", "Silver")->count();
        $goldusers = User::where("membership_plan", "Gold")->count();
        $orderslisting = Order::take(20)->get();
        return view('admin-view.dashboard.index', compact(
            'orders',
            'members',
            'user',
            'messages',
            'freeusers',
            'standardusers',
            'silverusers',
            'goldusers',
            'orderslisting'
        ));
    }
}
