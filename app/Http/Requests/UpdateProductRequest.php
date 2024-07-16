<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            'quantity' => ['required', 'integer', 'min:0', 'max:999'],
            'price' => ['required','numeric','between:0,9999.99'],
            'details' => ['required', 'string'],
            'image' => ['nullable', 'image', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O campo nome é obrigatório.',
            'name.string' => 'O campo nome deve ser uma cadeia de texto.',
            'name.max' => 'O campo nome não pode ter mais de 255 caracteres.',
            'quantity.required' => 'O campo quantidade é obrigatório.',
            'quantity.integer' => 'O campo quantidade deve ser um número inteiro.',
            'quantity.min' => 'O campo quantidade deve ser no mínimo 0.',
            'quantity.max' => 'O campo quantidade não pode ser maior do que 999.',
            'price.required' => 'O campo preço é obrigatório.',
            'price.numeric' => 'O campo preço deve ser um número.',
            'price.between' => 'O campo preço deve estar entre 0 e 9999.99.',
            'details.required' => 'O campo detalhes é obrigatório.',
            'details.string' => 'O campo detalhes deve ser uma cadeia de texto.',
            'image.image' => 'O campo imagem deve ser uma imagem.',
            'image.max' => 'O campo imagem não pode ser maior do que 2048 kilobytes.',
        ];
    }

}
