<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\AdminRequests\LoginRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index()
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard'); // Redirect to admin dashboard if already logged in
        }
        return view('admin-view.index');
    }

    public function Login(LoginRequest $request)
    {
      $credentials = $request->only('email', 'password');

      if (Auth::guard('admin')->attempt($credentials)) {
            // Authentication passed...
            return response()->json(['message' => 'Login successful'], 200);
        }

      return response()->json(['message' => 'The provided credentials do not match our records.'], 401);
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.index');
    }
}
