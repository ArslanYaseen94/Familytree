<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConfigurationController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view("user-view.configuration.security", compact("user"));
    }
    public function general()
    {
        $user = Auth::user();
        return view("user-view.configuration.general",compact("user"));
    }
}
