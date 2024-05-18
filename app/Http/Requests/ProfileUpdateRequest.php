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
            'full_name' => ['required', 'string', 'max:255'],
            'birth_date' => ['required', 'date'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
            'phone_number' => ['required', 'string', 'digits:9'],
            'gender' => ['required', 'string', Rule::in(['male', 'female', 'other'])],
            'other_gender' => ['nullable', 'string', 'max:255'], // Somente necessário se gender for 'other'
            'nif' => ['required', 'string', 'digits:9'],
            'cc_number' => ['required', 'string', 'max:9'],
        ];
    }
}
