<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreLeadRequest extends FormRequest
{
    public function authorize()
    {
        return true; // controller will call policy
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:191',
            'phone' => 'required|string|max:50',
            'email' => 'nullable|email|max:191',
            'message' => 'nullable|string',
            'product_text' => 'nullable|string',
            'source_id' => 'nullable|integer|exists:lead_sources,id',
            'status_id' => 'nullable|integer|exists:lead_statuses,id',
            'assigned_to' => 'nullable|integer|exists:users,id',
        ];
    }
}
