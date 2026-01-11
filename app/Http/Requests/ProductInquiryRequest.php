<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductInquiryRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:191',
            'phone' => 'required|string|max:50',
            'email' => 'nullable|email|max:191',
            'product_text' => 'nullable|string',
            'message' => 'nullable|string',
        ];
    }
}
