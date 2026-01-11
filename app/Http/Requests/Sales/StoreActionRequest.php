<?php

namespace App\Http\Requests\Sales;

use Illuminate\Foundation\Http\FormRequest;

class StoreActionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'action_type_id' => 'required|integer|exists:action_types,id',
            'notes' => 'nullable|string',
            'scheduled_at' => 'nullable|date',
        ];
    }
}
