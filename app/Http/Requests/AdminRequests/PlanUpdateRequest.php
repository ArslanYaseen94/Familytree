<?php

namespace App\Http\Requests\AdminRequests;

use Illuminate\Foundation\Http\FormRequest;

class PlanUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Change this based on your authorization logic
    }

    public function rules()
    {
        return [
          'edit_name' => 'required|string',
          'edit_monthly_price' => 'required|string',
          'edit_monthly_famillies' => 'required|string',
          'edit_monthly_members' => 'required|string',
          'edit_monthly_private' => 'required|string',
          'edit_yearly_price' => 'required|string',
          'edit_yearly_famillies' => 'required|string',
          'edit_yearly_members' => 'required|string',
          'edit_yearly_private' => 'required|string',
        ];
    }
}
