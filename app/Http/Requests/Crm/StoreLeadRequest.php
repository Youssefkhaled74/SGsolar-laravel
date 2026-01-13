<?php

namespace App\Http\Requests\Crm;

use Illuminate\Foundation\Http\FormRequest;

class StoreLeadRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check();
    }

    public function rules()
    {
        return [
            'name' => ['required','string','max:191'],
            'phone' => ['nullable','string','max:50'],
            'email' => ['nullable','email','max:191'],
            'message' => ['nullable','string'],
            'product_text' => ['nullable','string','max:255'],
            'source_id' => ['nullable','exists:lead_sources,id'],
            'status_id' => ['nullable','exists:lead_statuses,id'],
            'assigned_to' => ['nullable','exists:users,id'],
        ];
    }
}
