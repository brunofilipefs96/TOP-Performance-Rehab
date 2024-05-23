<?php

namespace Database\Seeders;

use App\Models\QuestionType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuestionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $questionTypes = [
            'multiple_questions',
            'boolean',
            'single_question',
        ];

        foreach ($questionTypes as $questionType) {
            QuestionType::factory()->create([
                'name' => $questionType,
            ]);
        }
    }
}
