<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'full_name' => 'required|string|max:255',
            'phone_number' => 'required|digits:9',
            'gender' => 'required|string',
            'other_gender' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'full_name.required' => 'O nome completo é obrigatório.',
            'full_name.string' => 'O nome completo deve ser uma string.',
            'full_name.max' => 'O nome completo não pode ter mais que 255 caracteres.',
            'phone_number.required' => 'O número de telefone é obrigatório.',
            'phone_number.digits' => 'O número de telefone deve ter exatamente 9 dígitos.',
            'gender.required' => 'O gênero é obrigatório.',
            'gender.string' => 'O gênero deve ser uma string.',
            'other_gender.string' => 'O outro gênero deve ser uma string.',
            'other_gender.max' => 'O outro gênero não pode ter mais que 255 caracteres.',
        ];
    }
}

