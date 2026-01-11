<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class IndexLeadsRequest extends FormRequest
{
    public function authorize()
    {
        return true; // controller will authorize via policies
    }

    public function rules()
    {
        return [
            'search' => 'nullable|string|max:191',
            'source_id' => 'nullable|integer|exists:lead_sources,id',
            'status_id' => 'nullable|integer|exists:lead_statuses,id',
            'assigned_to' => 'nullable|integer|exists:users,id',
            'date_from' => 'nullable|date',
            'date_to' => 'nullable|date',
            'per_page' => 'nullable|integer|min:1|max:200',
        ];
    }
}
