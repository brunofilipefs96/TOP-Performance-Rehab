<?php

namespace Database\Seeders;

use App\Models\Questionnaire;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuestionnaireSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Questionnaire::factory()->create([
            'title' => 'Questionário de Matricula',
            'description' => 'Questões de prontidão para a prática de atividade física (adaptado de PAR-Q).',
        ]);
    }
}
