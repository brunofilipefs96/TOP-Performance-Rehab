<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuestionRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'questionnaire_id' => 'required|exists:questionnaires,id',
            'question_type_id' => 'required|exists:question_types,id',
            'question_text' => 'required|string',
        ];
    }
}
