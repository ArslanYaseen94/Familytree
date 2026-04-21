<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest\FamilyTreeStoreRequest;
use App\Http\Requests\UserRequest\FamilyTreeUpdateRequest;
use App\Http\Requests\UserRequest\MemberStoreRequest;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use App\Models\FamilyTree;
use App\Models\Member;
use App\Models\SocialMedia;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{


    public function update(Request $request)
    {
        // dd($request->all());
        $user = Auth::user();

        $user = User::find($user->id);
        // Update profile info
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->bday = $request->dob;

        // Handle password change
        if ($request->filled('current_password') && $request->filled('new_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => __('messages.Current password is incorrect.')]);
            }
            $user->password = Hash::make($request->new_password);
        }

        $user->save();

        return back()->with(__('messages.success'), __('messages.Profile updated successfully.'));
    }
    public function generalupdate(Request $request){

        $user = Auth::user();

        $user = User::find($user->id);

        $user->site_url = $request->input("name");

        $user->save();

        return back()->with(__('messages.success'), __('messages.General updated successfully.'));
    }
    public function storesocials(Request $request)
    {
        $user = Auth::user();

        SocialMedia::updateOrCreate(
            ['user_id' => $user->id], // Condition to check
            [
                'facebook'  => $request->facebook,
                'linkedin'  => $request->linkedin,  
                'twitter'   => $request->twitter,
                'instagram' => $request->instagram,
            ]
        );

        return back()->with(__('messages.success'), __('messages.Socials updated successfully.'));
    }
}
