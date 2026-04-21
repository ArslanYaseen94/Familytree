<?php

namespace App\Http\Requests\AdminRequests;

use Illuminate\Foundation\Http\FormRequest;

class PlanStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Change this based on your authorization logic
    }

    public function rules()
    {
        return [
          'name' => 'required|string',
          'monthly_price' => 'required|string',
          'monthly_famillies' => 'required|string',
          'monthly_members' => 'required|string',
          'yearly_price' => 'required|string',
          'yearly_famillies' => 'required|string',
          'yearly_members' => 'required|string',
        ];
    }
}
