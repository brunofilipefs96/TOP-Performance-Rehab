<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class StoreTrainingRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'training_type_id' => 'required|exists:training_types,id',
            'room_id' => 'required|exists:rooms,id',
            'max_students' => 'required|integer|min:1',
            'personal_trainer_id' => 'nullable|exists:users,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $startDate = Carbon::createFromFormat('Y-m-d\TH:i', $this->start_date);
            $endDate = Carbon::createFromFormat('Y-m-d\TH:i', $this->end_date);

            $duration = $startDate->diffInMinutes($endDate);

            if ($duration < 20) {
                $validator->errors()->add('end_date', 'A duração do treino deve ser de pelo menos 20 minutos.');
            }

            if ($duration > 120) {
                $validator->errors()->add('end_date', 'A duração do treino não pode exceder 2 horas.');
            }
        });
    }

}
