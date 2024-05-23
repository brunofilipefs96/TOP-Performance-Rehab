<?php

namespace Database\Seeders;

use App\Models\Question;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // QuestionTypes: 1-> multiple_questions, 2-> boolean, 3-> single_question

        $questions = [
            [
                'questionnaire_id' => 1,
                'question_type_id' => 2,
                'question_text' => 'O seu médico já lhe disse que tem um problema de saúde e que apenas só deverá fazer exercício físico sob supervisão médica?',
            ],
            [
                'questionnaire_id' => 1,
                'question_type_id' => 2,
                'question_text' => 'Sente dor no peito ao realizar exercícios físicos?',
            ],
            [
                'questionnaire_id' => 1,
                'question_type_id' => 2,
                'question_text' => 'No último mês, sentiu dor no peito quando não estava a realizar qualquer exercício físico?',
            ],
            [
                'questionnaire_id' => 1,
                'question_type_id' => 2,
                'question_text' => 'Já perdeu a consciência em alguma ocasião ou sofreu alguma queda em virtude de tontura?',
            ],
            [
                'questionnaire_id' => 1,
                'question_type_id' => 2,
                'question_text' => 'Tem algum problema ósseo ou articular que pode agravar com a prática de exercícios físicos?',
            ],
            [
                'questionnaire_id' => 1,
                'question_type_id' => 2,
                'question_text' => 'Algum médico já lhe prescreveu medicamento para a pressão arterial ou para o coração?',
            ],
            [
                'questionnaire_id' => 1,
                'question_type_id' => 2,
                'question_text' => 'Tem conhecimento, por informação médica ou pela sua própria experiência, de algum motivo que poderia impedi-lo de praticar exercícios físicos sem supervisão médica?',
            ]    //Depois destas perguntas, Impossibilitado de praticar Exercício Físico
                 // site: https://docs.google.com/forms/d/e/1FAIpQLSe9zkVzw0m3-0jQEvpnWwul2dZ_7MLENImhemwbzGw4Zy10vA/formResponse?pli=1
        ];

        foreach ($questions as $question) {
            Question::factory()->create($question);
        }
    }
}
