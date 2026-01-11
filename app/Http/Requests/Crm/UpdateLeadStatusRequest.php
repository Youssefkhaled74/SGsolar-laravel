<?php

namespace App\Http\Requests\Crm;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLeadStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $status = $this->route('status');
        $id = $status ? $status->id : null;

        return [
            'name' => ['required','string','max:50','unique:lead_statuses,name,' . $id],
            'is_active' => ['sometimes','boolean'],
        ];
    }
}
