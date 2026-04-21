<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\AdminRequests\PasswordUpdateRequest; // as admin requirement 
use App\Http\Requests\UserRequest\ProfileUpdateRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserProfileController extends Controller
{
    public function index()
    {
        $userinfo = Auth::guard('web')->user();
        return view('user-view.settings.profile', compact('userinfo'));
    }

    public function update(ProfileUpdateRequest $request)
    {
        $name = $request->name;
        $Phone = $request->Phone;
        $email = $request->email;
        $gender = $request->gender;
        $bday = $request->bday;
        $bio = $request->bio;
        $update_date = date('Y-m-d H:i:s');

        try {
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = rand() . '' . time() . '.' . $image->extension();
                $image->move(public_path('assets/front-end/ProfileImgs'), $imageName);
            } else {
                // Keep the existing image if no new image is uploaded
                $imageName = Auth::guard('web')->user()->profileImg;
            }

            User::where('id', Auth::guard('web')->user()->id)
                ->update([
                    'name' => $name,
                    'Phone' => $Phone,
                    'email' => $email,
                    'gender' => $gender,
                    'bday' => $bday,
                    'bio' => $bio,
                    'profileImg' => $imageName,
                    'updated_at' => $update_date
                ]);

            return redirect()->back()->with(__('messages.success'), __('messages.Information Updated Successfully'));
        } catch (\Illuminate\Database\QueryException $ex) {
            // Handle the exception
            return response()->json(['message' => __('messages.Failed to update information'), 'error' => $ex->getMessage()], 500);
        }
    }
    public function Password(PasswordUpdateRequest $request)
    {
        $Old_Password = $request->Old_Password;
        $New_password = $request->New_password;
        $Confirm_password = $request->Confirm_password;

        if (Hash::check($Old_Password, Auth::guard('web')->user()->password)) {
            $pass =  bcrypt($New_password);
            try {
                User::where('id', Auth::guard('web')->user()->id)
                    ->update([
                        'password' => $pass,
                    ]);
                return response()->json(['message' => __('messages.Password Updated successfully')], 200);
            } catch (\Illuminate\Database\QueryException $ex) {
            }
        } else {
            return response()->json(['message' => __('messages.Old password not match')], 401);
        }
    }
}
