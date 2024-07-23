<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEvaluationRequest extends FormRequest
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
            'weight' => 'nullable|numeric|min:0|max:500',
            'height' => 'nullable|numeric|min:0|max:300',
            'waist' => 'nullable|numeric|min:0|max:300',
            'hip' => 'nullable|numeric|min:0|max:300',
            'chest' => 'nullable|numeric|min:0|max:300',
            'arm' => 'nullable|numeric|min:0|max:100',
            'forearm' => 'nullable|numeric|min:0|max:100',
            'thigh' => 'nullable|numeric|min:0|max:150',
            'calf' => 'nullable|numeric|min:0|max:100',
            'abdominal_fat' => 'nullable|numeric|min:0|max:100',
            'visceral_fat' => 'nullable|numeric|min:0|max:100',
            'muscle_mass' => 'nullable|numeric|min:0|max:100',
            'fat_mass' => 'nullable|numeric|min:0|max:100',
            'hydration' => 'nullable|numeric|min:0|max:100',
            'bone_mass' => 'nullable|numeric|min:0|max:100',
            'bmr' => 'nullable|numeric|min:0|max:5000',
            'metabolic_age' => 'nullable|numeric|min:0|max:150',
            'physical_evaluation' => 'nullable|string|max:500',
            'fat_percentage' => 'nullable|numeric|min:0|max:100',
            'imc' => 'nullable|numeric|min:0|max:100',
            'ideal_weight' => 'nullable|numeric|min:0|max:500',
            'ideal_fat_percentage' => 'nullable|numeric|min:0|max:100',
            'ideal_muscle_mass' => 'nullable|numeric|min:0|max:100',
            'observations' => 'nullable|string|max:500',
            'date' => 'required|date',
            'documents.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'membership_id.required' => 'O campo de identificação de adesão é obrigatório.',
            'membership_id.exists' => 'A adesão selecionada não existe.',
            'weight.numeric' => 'O peso deve ser um número.',
            'weight.min' => 'O peso não pode ser menor que 0 kg.',
            'weight.max' => 'O peso não pode ser maior que 500 kg.',
            'height.numeric' => 'A altura deve ser um número.',
            'height.min' => 'A altura não pode ser menor que 0 cm.',
            'height.max' => 'A altura não pode ser maior que 300 cm.',
            'waist.numeric' => 'A cintura deve ser um número.',
            'waist.min' => 'A cintura não pode ser menor que 0 cm.',
            'waist.max' => 'A cintura não pode ser maior que 300 cm.',
            'hip.numeric' => 'O quadril deve ser um número.',
            'hip.min' => 'O quadril não pode ser menor que 0 cm.',
            'hip.max' => 'O quadril não pode ser maior que 300 cm.',
            'chest.numeric' => 'O peito deve ser um número.',
            'chest.min' => 'O peito não pode ser menor que 0 cm.',
            'chest.max' => 'O peito não pode ser maior que 300 cm.',
            'arm.numeric' => 'O braço deve ser um número.',
            'arm.min' => 'O braço não pode ser menor que 0 cm.',
            'arm.max' => 'O braço não pode ser maior que 100 cm.',
            'forearm.numeric' => 'O antebraço deve ser um número.',
            'forearm.min' => 'O antebraço não pode ser menor que 0 cm.',
            'forearm.max' => 'O antebraço não pode ser maior que 100 cm.',
            'thigh.numeric' => 'A coxa deve ser um número.',
            'thigh.min' => 'A coxa não pode ser menor que 0 cm.',
            'thigh.max' => 'A coxa não pode ser maior que 150 cm.',
            'calf.numeric' => 'A panturrilha deve ser um número.',
            'calf.min' => 'A panturrilha não pode ser menor que 0 cm.',
            'calf.max' => 'A panturrilha não pode ser maior que 100 cm.',
            'abdominal_fat.numeric' => 'A gordura abdominal deve ser um número.',
            'abdominal_fat.min' => 'A gordura abdominal não pode ser menor que 0%.',
            'abdominal_fat.max' => 'A gordura abdominal não pode ser maior que 100%.',
            'visceral_fat.numeric' => 'A gordura visceral deve ser um número.',
            'visceral_fat.min' => 'A gordura visceral não pode ser menor que 0%.',
            'visceral_fat.max' => 'A gordura visceral não pode ser maior que 100%.',
            'muscle_mass.numeric' => 'A massa muscular deve ser um número.',
            'muscle_mass.min' => 'A massa muscular não pode ser menor que 0%.',
            'muscle_mass.max' => 'A massa muscular não pode ser maior que 100%.',
            'fat_mass.numeric' => 'A massa gorda deve ser um número.',
            'fat_mass.min' => 'A massa gorda não pode ser menor que 0%.',
            'fat_mass.max' => 'A massa gorda não pode ser maior que 100%.',
            'hydration.numeric' => 'A hidratação deve ser um número.',
            'hydration.min' => 'A hidratação não pode ser menor que 0%.',
            'hydration.max' => 'A hidratação não pode ser maior que 100%.',
            'bone_mass.numeric' => 'A massa óssea deve ser um número.',
            'bone_mass.min' => 'A massa óssea não pode ser menor que 0%.',
            'bone_mass.max' => 'A massa óssea não pode ser maior que 100%.',
            'bmr.numeric' => 'A taxa metabólica basal deve ser um número.',
            'bmr.min' => 'A taxa metabólica basal não pode ser menor que 0 kcal.',
            'bmr.max' => 'A taxa metabólica basal não pode ser maior que 5000 kcal.',
            'metabolic_age.numeric' => 'A idade metabólica deve ser um número.',
            'metabolic_age.min' => 'A idade metabólica não pode ser menor que 0 anos.',
            'metabolic_age.max' => 'A idade metabólica não pode ser maior que 150 anos.',
            'physical_evaluation.string' => 'A avaliação física deve ser um texto.',
            'physical_evaluation.max' => 'A avaliação física não pode ser maior que 500 caracteres.',
            'fat_percentage.numeric' => 'O percentual de gordura deve ser um número.',
            'fat_percentage.min' => 'O percentual de gordura não pode ser menor que 0%.',
            'fat_percentage.max' => 'O percentual de gordura não pode ser maior que 100%.',
            'imc.numeric' => 'O IMC deve ser um número.',
            'imc.min' => 'O IMC não pode ser menor que 0.',
            'imc.max' => 'O IMC não pode ser maior que 100.',
            'ideal_weight.numeric' => 'O peso ideal deve ser um número.',
            'ideal_weight.min' => 'O peso ideal não pode ser menor que 0 kg.',
            'ideal_weight.max' => 'O peso ideal não pode ser maior que 500 kg.',
            'ideal_fat_percentage.numeric' => 'O percentual de gordura ideal deve ser um número.',
            'ideal_fat_percentage.min' => 'O percentual de gordura ideal não pode ser menor que 0%.',
            'ideal_fat_percentage.max' => 'O percentual de gordura ideal não pode ser maior que 100%.',
            'ideal_muscle_mass.numeric' => 'A massa muscular ideal deve ser um número.',
            'ideal_muscle_mass.min' => 'A massa muscular ideal não pode ser menor que 0%.',
            'ideal_muscle_mass.max' => 'A massa muscular ideal não pode ser maior que 100%.',
            'observations.string' => 'As observações devem ser um texto.',
            'observations.max' => 'As observações não podem ser maiores que 500 caracteres.',
            'date.required' => 'A data é obrigatória.',
            'date.date' => 'A data deve ser uma data válida.',
            'documents.*.file' => 'Cada documento deve ser um arquivo válido.',
            'documents.*.mimes' => 'Cada documento deve ser um arquivo do tipo: pdf, jpg, jpeg, png, doc, docx.',
            'documents.*.max' => 'Cada documento não deve ter mais de 2MB.',
        ];
    }
}
