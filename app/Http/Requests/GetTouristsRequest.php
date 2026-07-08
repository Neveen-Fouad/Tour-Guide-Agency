<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetTouristsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'page'     => ['sometimes', 'integer', 'min:1'],
            'per_page' => ['sometimes', 'integer', 'min:1', 'max:100'],
            'search'   => ['sometimes', 'string', 'max:100'],
            'gender'   => ['sometimes', 'string', 'in:male,female'],
        ];
    }

    public function messages(): array
    {
        return [
            'page.integer'     => 'page must be an integer.',
            'page.min'         => 'page must be at least 1.',
            'per_page.integer' => 'per_page must be an integer.',
            'per_page.min'     => 'per_page must be at least 1.',
            'per_page.max'     => 'per_page cannot exceed 100.',
            'gender.in'        => 'gender must be male or female.',
        ];
    }
}
