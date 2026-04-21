<?php

namespace App\Http\Requests\AdminRequests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Change this based on your authorization logic
    }

    public function rules()
    {
        return [

          'name' => 'required|string',
          'bio' => 'required|string',
          'mobile_number' => 'required|numeric',
          'email' => 'required|string|email',
        ];
    }
}
