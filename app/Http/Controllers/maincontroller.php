<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class maincontroller extends Controller
{
    public function index()
    {
        $adminUser = Auth::guard('admin')->user();
        return view('admin-view.profile.index', compact('adminUser'));
    }
}
