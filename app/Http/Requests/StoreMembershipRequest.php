<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMembershipRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'cc_number' => 'digits:9|unique:users,cc_number',
            'address_id' => 'required|exists:addresses,id',
        ];
    }

    public function messages(): array
    {
        return [
            'cc_number.required' => 'O número de Cartão de Cidadão é obrigatório.',
            'cc_number.digits' => 'O número de Cartão de Cidadão deve ter exatamente 9 dígitos.',
            'cc_number.unique' => 'O número de Cartão de Cidadão já está em uso.',
            'address_id.required' => 'O campo de endereço é obrigatório.',
            'address_id.exists' => 'O endereço selecionado é inválido.',
        ];
    }
}
