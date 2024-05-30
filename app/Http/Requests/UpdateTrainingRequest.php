<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTrainingRequest extends FormRequest
{
   /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'training_type_id' => ['required', 'exists:training_types,id'],
            'room_id' => ['required', 'exists:rooms,id'],
            'name' => ['required', 'string', 'max:255'],
            'max_students' => ['required', 'integer', 'min:0', 'max:999'],
            'start_date' => ['required', 'date', 'after_or_equal:today'],
            'end_date' => ['required', 'date', 'after:start_date', 'after_or_equal:today'],
            'personal_trainer_id' => ['nullable', 'exists:personal_trainers,id'],
        ];
    }
}
