<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'full_name' => 'required|string|max:255',
            'phone_number' => 'required|digits:9',
            'gender' => 'required|string',
            'other_gender' => 'nullable|string|max:255',
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
