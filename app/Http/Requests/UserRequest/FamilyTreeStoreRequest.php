<?php

namespace App\Http\Requests\UserRequest;

use Illuminate\Foundation\Http\FormRequest;

class FamilyTreeStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Change this based on your authorization logic
    }

    public function rules()
    {
        return [

          // Pakistan CNIC format: 12345-1234567-1
          'familyid' => ['required', 'regex:/^\d{5}-\d{7}-\d{1}$/'],
        ];
    }
}
