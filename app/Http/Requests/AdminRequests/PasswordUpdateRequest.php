<?php

namespace App\Http\Requests\AdminRequests;

use Illuminate\Foundation\Http\FormRequest;

class PasswordUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Change this based on your authorization logic
    }

    public function rules()
    {
        return [

          'Old_Password' => 'required|string',
          'New_password' => 'required|string',
          'Confirm_password' => 'required|string|same:New_password',
        ];
    }
}
