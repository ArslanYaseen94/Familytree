<?php

namespace App\Http\Requests\UserRequest;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Change this based on your authorization logic
    }

    public function rules()
    {
        return [
          'name' => 'required|string|',
          'email' => 'required|string|email',
          'password' => 'required|string',
          'familyId' => 'required|string',
        ];
    }
}
