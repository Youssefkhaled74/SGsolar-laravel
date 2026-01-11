<?php

namespace App\Http\Requests\Crm;

use Illuminate\Foundation\Http\FormRequest;

class StoreLeadFollowupRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'scheduled_at' => ['required','date'],
            'note' => ['nullable','string','max:2000'],
            'assigned_to' => ['nullable','integer','exists:users,id'],
            'lead_action_id' => ['nullable','integer','exists:lead_actions,id'],
        ];
    }
}
