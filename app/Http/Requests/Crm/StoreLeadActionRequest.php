<?php

namespace App\Http\Requests\Crm;

use Illuminate\Foundation\Http\FormRequest;

class StoreLeadActionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'action_type_id' => ['required','integer','exists:action_types,id'],
            'notes' => ['nullable','string','max:2000'],
            'scheduled_at' => ['nullable','date'],
        ];
    }
}
