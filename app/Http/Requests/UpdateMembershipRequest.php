<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMembershipRequest extends FormRequest
{
     /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'address_id' => ['required', 'integer', 'exists:addresses,id'],
            'monthly_plan' => ['required', 'boolean'],
            'total_trainings_supervised' => ['required', 'integer'],
            'total_trainings_individual' => ['required', 'integer'],
            'status' => ['required', 'string', 'max:255']
        ];
    }
}
