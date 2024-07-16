<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoomRequest extends FormRequest
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
            'capacity' => ['required', 'integer', 'min:0', 'max:999'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O nome é obrigatório.',
            'name.string' => 'O nome deve ser uma string.',
            'name.max' => 'O nome não pode ter mais que 255 caracteres.',
            'capacity.required' => 'A capacidade é obrigatória.',
            'capacity.integer' => 'A capacidade deve ser um número inteiro.',
            'capacity.min' => 'A capacidade mínima é 0.',
            'capacity.max' => 'A capacidade máxima é 999.',
        ];
    }
}
