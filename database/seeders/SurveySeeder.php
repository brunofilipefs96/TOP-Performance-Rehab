<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use MattDaneshvar\Survey\Models\Survey;

class SurveySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $survey = Survey::create(['name' => 'Ficha Anamnese']);

        $survey->questions()->create([
            'content' => 'How many cats do you have?',
            'type' => 'number',
            'rules' => ['required','numeric', 'min:0']
        ]);

        $survey->questions()->create([
            'content' => 'What\'s the name of your first cat',
        ]);

        $survey->questions()->create([
            'content' => 'Would you want a new cat?',
            'type' => 'radio',
            'options' => ['Yes', 'Oui']
        ]);

        $survey->questions()->create([
            'content' => 'Would you want a new cat?',
            'type' => 'radio',
            'options' => ['Yes', 'Oui']
        ]);


    }
}
