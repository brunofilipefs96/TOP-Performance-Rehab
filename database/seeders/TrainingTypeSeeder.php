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
        $trainingTypes = [
            ['name' => 'Treino Funcional Livre', 'image' => 'training_types/default.png', 'has_personal_trainer' => false, 'max_capacity' => null, 'is_electrostimulation' => false],
            ['name' => 'PT Individual', 'image' => 'training_types/default.png', 'has_personal_trainer' => true, 'max_capacity' => 1, 'is_electrostimulation' => false],
            ['name' => 'PT Duo (Dois Clientes)', 'image' => 'training_types/default.png', 'has_personal_trainer' => true, 'max_capacity' => 2, 'is_electrostimulation' => false],
            ['name' => 'PT Trio (Três Clientes)', 'image' => 'training_types/default.png', 'has_personal_trainer' => true, 'max_capacity' => 3, 'is_electrostimulation' => false],
            ['name' => 'PT Individual de Eletroestimulação', 'image' => 'training_types/default.png', 'has_personal_trainer' => true, 'max_capacity' => 1, 'is_electrostimulation' => true],
            ['name' => 'PT Individual de Pilates Equipamentos', 'image' => 'training_types/default.png', 'has_personal_trainer' => true, 'max_capacity' => 1, 'is_electrostimulation' => false],
            ['name' => 'Treino Funcional', 'image' => 'training_types/default.png', 'has_personal_trainer' => true, 'max_capacity' => null, 'is_electrostimulation' => false],
        ];

        foreach ($trainingTypes as $type) {
            TrainingType::create($type);
        }
    }
}
