<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEvaluationRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'membership_id' => 'required|exists:memberships,id',
            'weight' => 'nullable|numeric',
            'height' => 'nullable|numeric',
            'waist' => 'nullable|numeric',
            'hip' => 'nullable|numeric',
            'chest' => 'nullable|numeric',
            'arm' => 'nullable|numeric',
            'forearm' => 'nullable|numeric',
            'thigh' => 'nullable|numeric',
            'calf' => 'nullable|numeric',
            'abdominal_fat' => 'nullable|numeric',
            'visceral_fat' => 'nullable|numeric',
            'muscle_mass' => 'nullable|numeric',
            'fat_mass' => 'nullable|numeric',
            'hydration' => 'nullable|numeric',
            'bone_mass' => 'nullable|numeric',
            'bmr' => 'nullable|numeric',
            'metabolic_age' => 'nullable|numeric',
            'physical_evaluation' => 'nullable|numeric',
            'fat_percentage' => 'nullable|numeric',
            'imc' => 'nullable|numeric',
            'ideal_weight' => 'nullable|numeric',
            'ideal_fat_percentage' => 'nullable|numeric',
            'ideal_muscle_mass' => 'nullable|numeric',
            'observations' => 'nullable|string',
            'date' => 'required|date',
        ];
    }
}
