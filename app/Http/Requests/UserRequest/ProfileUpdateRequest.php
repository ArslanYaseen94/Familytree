<?php

namespace App\Http\Requests\UserRequest;

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
          'Phone' => 'required|numeric',
          'email' => 'required|string|email',
          'gender' => 'required',
        ];
    }
}
