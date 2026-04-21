<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest\LoginRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserLoginController extends Controller
{

    public function index()
    {
        if (Auth::guard('web')->check()) {
            return redirect()->route('user.dashboard'); // Redirect to admin dashboard if already logged in
        }
        return view('user-view.index');
    }
    public function login(LoginRequest $request)
    {
        $email = $request->email;
        $password = $request->password;
    
        // Retrieve the user by email
        $user = User::where('email', $email)->first();
    
        // Check if the user exists and their status is active (Status = 0)
        if ($user && $user->Status == 0) {
            // Verify the password
            if (Auth::guard('web')->attempt(['email' => $email, 'password' => $password])) {
                // Authentication passed...
                return response()->json(['message' => __('messages.Login successfully...')], 200);
            } else {
                // Password does not match
                return response()->json(['message' => __('messages.The provided credentials do not match our records.')], 401);
            }
        } else {
            // User is not active or does not exist
            return response()->json(['message' => __('messages.Your account is inactive or does not exist.')], 403);
        }
    }


    public function logout()
    {
        Auth::guard('web')->logout();
        return redirect()->route('user.loginpage');
    }
}
