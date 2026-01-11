<?php

namespace App\Http\Requests\Crm;

use Illuminate\Foundation\Http\FormRequest;

class UpdateActionTypeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $type = $this->route('type');
        $id = $type ? $type->id : null;

        return [
            'name' => ['required','string','max:50','unique:action_types,name,' . $id],
            'is_active' => ['sometimes','boolean'],
        ];
    }
}
