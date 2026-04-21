<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest\RegisterRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Password;
class UserRegisterController extends Controller
{

  public function index()
  {
    if (Auth::guard('web')->check()) {
      return redirect()->route('user.dashboard'); // Redirect to admin dashboard if already logged in
    }
    return view('user-view.register');
  }

public function register(RegisterRequest $request)
{

    try {
        $now = now();

        // Prepare data
        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'familyId' => $request->familyId,
            'country' => $request->country,
            'state' => $request->state,
            'city' => $request->city,
            'phone' => $request->phone,
            'created_at' => $now,
            'updated_at' => $now,
        ];

        // Insert user
        User::insert($userData);

        // Attempt login
        $credentials = $request->only('email', 'password');
        if (Auth::guard('web')->attempt($credentials)) {
            return response()->json(['message' => __('message.Register successfully...')], 200);
        } else {
            return redirect()->route('user.loginpage');
        }
    } catch (\Illuminate\Database\QueryException $ex) {
        return response()->json(['error' => __(__('messages.Something went wrong.'))], 500);
    }
}
    public function showLinkRequestForm()
    {
        return view('user-view.forgot');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            return response()->json(['message' => __($status)]);
        }

        return response()->json(['message' => __($status)], 400);
    }
}

