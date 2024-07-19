<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTrainingTypeRequest extends FormRequest
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
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'has_personal_trainer' => ['required', 'boolean'],
            'max_capacity' => ['nullable', 'integer', 'min:1'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O nome é obrigatório.',
            'name.string' => 'O nome deve ser uma string.',
            'name.max' => 'O nome não pode ter mais que 255 caracteres.',
            'image.image' => 'O arquivo deve ser uma imagem.',
            'image.mimes' => 'A imagem deve ser do tipo: jpeg, png, jpg, gif, svg.',
            'image.max' => 'A imagem não pode ter mais que 2048 kilobytes.',
            'has_personal_trainer.required' => 'O campo de personal trainer é obrigatório.',
            'has_personal_trainer.boolean' => 'O campo de personal trainer deve ser verdadeiro ou falso.',
            'max_capacity.integer' => 'A capacidade máxima deve ser um número inteiro.',
            'max_capacity.min' => 'A capacidade máxima deve ser pelo menos 1.',
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        if ($this->has_personal_trainer == "true" || $this->has_personal_trainer == "1") {
            $this->merge(['has_personal_trainer' => true]);
        } else {
            $this->merge(['has_personal_trainer' => false]);
        }
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     */
    protected function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->has_personal_trainer && is_null($this->max_capacity)) {
                return;
            }
            if ($this->has_personal_trainer && $this->max_capacity <= 0) {
                $validator->errors()->add('max_capacity', 'Capacidade máxima deve ser maior que 0 quando tem personal trainer.');
            }
        });
    }
}
