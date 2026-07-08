<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTouristRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'string', 'max:50'],
            'email' => ['sometimes', 'email'],
            'password' => ['sometimes', 'string'],
            'phone' => ['sometimes', 'string', 'max:20'],
            'age' => ['sometimes', 'integer'],
            'gender' => ['sometimes', 'string', 'in:male,female'],
            'profile_picture' => ['sometimes', 'string'],
        ];
    }
}