<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePackRequest extends FormRequest
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
            'duration' => ['required', 'integer', 'min:1'],
            'trainings_number' => ['required', 'integer', 'min:1'],
            'training_type_id' => ['required', 'exists:training_types,id'],
            'price' => ['required', 'numeric', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O nome é obrigatório.',
            'name.string' => 'O nome deve ser uma string.',
            'name.max' => 'O nome não pode ter mais que 255 caracteres.',
            'duration.required' => 'A duração é obrigatória.',
            'duration.integer' => 'A duração deve ser um número inteiro.',
            'duration.min' => 'A duração deve ser pelo menos 1 dia.',
            'trainings_number.required' => 'O número de treinos é obrigatório.',
            'trainings_number.integer' => 'O número de treinos deve ser um número inteiro.',
            'trainings_number.min' => 'O número de treinos deve ser pelo menos 1.',
            'training_type_id.required' => 'O tipo de treino é obrigatório.',
            'training_type_id.exists' => 'O tipo de treino selecionado é inválido.',
            'price.required' => 'O preço é obrigatório.',
            'price.numeric' => 'O preço deve ser um número.',
            'price.min' => 'O preço deve ser pelo menos 0.',
        ];
    }
}
