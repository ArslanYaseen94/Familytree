<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\AdminRequests\ProfileUpdateRequest;
use App\Http\Requests\AdminRequests\PasswordUpdateRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class AdminProfileController extends Controller
{
    public function index()
    {
        $adminUser = Auth::guard('admin')->user();
        return view('admin-view.profile.index', compact('adminUser'));
    }

    public function update(ProfileUpdateRequest $request)
    {
      $name=$request->name;
      $bio=$request->bio;
      $mobile_number=$request->mobile_number;
      $email=$request->email;
      try {
        Admin::where('id', Auth::guard('admin')->user()->id)
         ->update([
             'name' => $name,
             'phone' => $mobile_number,
             'bio' => $bio,
             'email' => $email
          ]);
         return response()->json(['message' => 'Upadte information successfully'], 200);

      } catch(\Illuminate\Database\QueryException $ex){
        
      }
    }

    public function Password(PasswordUpdateRequest $request)
    {
      $Old_Password=$request->Old_Password;
      $New_password=$request->New_password;
      $Confirm_password=$request->Confirm_password;

      if (Hash::check($Old_Password, Auth::guard('admin')->user()->password)) {
        $pass =  bcrypt($New_password);
        try {
            Admin::where('id', Auth::guard('admin')->user()->id)
             ->update([
                 'password' => $pass,
              ]);
             return response()->json(['message' => 'Upadte Password successfully'], 200);

          } catch(\Illuminate\Database\QueryException $ex){
            
          }
      }
      else{
        return response()->json(['message' => 'Old password not match'], 401);
      }
    }
}
