<?php

namespace App\Http\Requests\Crm;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLeadSourceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $source = $this->route('source');
        $id = $source ? $source->id : null;

        return [
            'name' => ['required','string','max:50','unique:lead_sources,name,' . $id],
            'is_active' => ['sometimes','boolean'],
        ];
    }
}
