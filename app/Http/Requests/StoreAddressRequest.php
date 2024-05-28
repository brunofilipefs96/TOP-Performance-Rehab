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
}
