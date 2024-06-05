<?php

namespace Database\Seeders;

use App\Models\TrainingType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TrainingTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tiposTreino = [
            ['name' => 'Cardio', 'image' => 'images/training_types/1/cardio.jpg'],
            ['name' => 'Treino de Força', 'image' => 'images/training_types/2/forca.jpg'],
            ['name' => 'Flexibilidade', 'image' => 'images/training_types/3/flexibilidade.jpg'],
            ['name' => 'Pilates', 'image' => 'images/training_types/4/pilates.jpg'],
            ['name' => 'Yoga', 'image' => 'images/training_types/5/yoga.jpg'],
            ['name' => 'HIIT', 'image' => 'images/training_types/6/hiit.jpg'],
            ['name' => 'CrossFit', 'image' => 'images/training_types/7/crossfit.jpg'],
            ['name' => 'Musculação', 'image' => 'images/training_types/8/musculacao.jpg'],
            ['name' => 'Cycling', 'image' => 'images/training_types/9/cycling.jpg'],
            ['name' => 'Aeróbica', 'image' => 'images/training_types/10/aerobica.jpg'],
        ];

        foreach ($tiposTreino as $tipo) {
            TrainingType::create($tipo);
        }
    }
}
