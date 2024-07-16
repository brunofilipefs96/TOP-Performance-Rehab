<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePackRequest extends FormRequest
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
            'price' => ['required', 'numeric', 'between:0,9999.99'],
            'trainings_number' => ['required', 'integer', 'between:1,999'],
            'has_personal_trainer' => ['required', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O nome é obrigatório.',
            'name.string' => 'O nome deve ser uma string.',
            'name.max' => 'O nome não pode ter mais que 255 caracteres.',
            'price.required' => 'O preço é obrigatório.',
            'price.numeric' => 'O preço deve ser um número.',
            'price.between' => 'O preço deve estar entre 0 e 9999,99.',
            'trainings_number.required' => 'O número de treinos é obrigatório.',
            'trainings_number.integer' => 'O número de treinos deve ser um número inteiro.',
            'trainings_number.between' => 'O número de treinos deve estar entre 1 e 999.',
            'has_personal_trainer.required' => 'O campo de personal trainer é obrigatório.',
            'has_personal_trainer.boolean' => 'O campo de personal trainer deve ser verdadeiro ou falso.',
        ];
    }
}
