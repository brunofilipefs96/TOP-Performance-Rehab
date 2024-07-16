<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAddressRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'street' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'postal_code' => [
                'required',
                'string',
                'max:8',
                function ($attribute, $value, $fail) {
                    if (!preg_match('/^\d{4}-\d{3}$/', $value)) {
                        $fail('O campo ' . $attribute . ' deve estar no formato xxxx-xxx.');
                    }
                },
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O nome é obrigatório.',
            'name.string' => 'O nome deve ser uma string.',
            'name.max' => 'O nome não pode ter mais que 255 caracteres.',
            'street.required' => 'A rua é obrigatória.',
            'street.string' => 'A rua deve ser uma string.',
            'street.max' => 'A rua não pode ter mais que 255 caracteres.',
            'city.required' => 'A cidade é obrigatória.',
            'city.string' => 'A cidade deve ser uma string.',
            'city.max' => 'A cidade não pode ter mais que 255 caracteres.',
            'postal_code.required' => 'O código postal é obrigatório.',
            'postal_code.string' => 'O código postal deve ser uma string.',
            'postal_code.max' => 'O código postal não pode ter mais que 8 caracteres.',
            'postal_code.regex' => 'O código postal deve estar no formato xxxx-xxx.',
        ];
    }
}
