<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTrainingTypeRequest extends FormRequest
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
        ];
    }
}
