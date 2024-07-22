<?php

namespace Database\Seeders;

use App\Models\Pack;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $packs = [
            ['name' => 'Treino Funcional Livre', 'trainings_number' => 5, 'duration' => 30, 'training_type_id' => 1, 'price' => 35.00],
            ['name' => 'Treino Funcional Livre', 'trainings_number' => 9, 'duration' => 30, 'training_type_id' => 1, 'price' => 62.00],
            ['name' => 'Treino Funcional Livre', 'trainings_number' => 13, 'duration' => 30, 'training_type_id' => 1, 'price' => 86.00],
            ['name' => 'PT Individual', 'trainings_number' => 5, 'duration' => 365, 'training_type_id' => 2, 'price' => 85.00],
            ['name' => 'PT Individual', 'trainings_number' => 9, 'duration' => 365, 'training_type_id' => 2, 'price' => 160.00],
            ['name' => 'PT Individual', 'trainings_number' => 12, 'duration' => 365, 'training_type_id' => 2, 'price' => 250.00],
            ['name' => 'PT DUO', 'trainings_number' => 5, 'duration' => 365, 'training_type_id' => 3, 'price' => 55.00],
            ['name' => 'PT DUO', 'trainings_number' => 9, 'duration' => 365, 'training_type_id' => 3, 'price' => 85.00],
            ['name' => 'PT DUO', 'trainings_number' => 13, 'duration' => 365, 'training_type_id' => 3, 'price' => 160.00],
            ['name' => 'PT TRIO', 'trainings_number' => 5, 'duration' => 365, 'training_type_id' => 4, 'price' => 37.00],
            ['name' => 'PT TRIO', 'trainings_number' => 9, 'duration' => 365, 'training_type_id' => 4, 'price' => 72.00],
            ['name' => 'PT TRIO', 'trainings_number' => 13, 'duration' => 365, 'training_type_id' => 4, 'price' => 110.00],
            ['name' => 'PT Individual de Eletroestimulação', 'trainings_number' => 5, 'duration' => 365, 'training_type_id' => 5, 'price' => 85.00],
            ['name' => 'PT Individual de Eletroestimulação', 'trainings_number' => 9, 'duration' => 365, 'training_type_id' => 5, 'price' => 160.00],
            ['name' => 'PT Individual de Eletroestimulação', 'trainings_number' => 13, 'duration' => 365, 'training_type_id' => 5, 'price' => 250.00],
            ['name' => 'PT Individual de Pilates Equipamentos', 'trainings_number' => 5, 'duration' => 365, 'training_type_id' => 6, 'price' => 140.00],
            ['name' => 'PT Individual de Pilates Equipamentos', 'trainings_number' => 9, 'duration' => 365, 'training_type_id' => 6, 'price' => 260.00],
            ['name' => 'PT Individual de Pilates Equipamentos', 'trainings_number' => 13, 'duration' => 365, 'training_type_id' => 6, 'price' => 360.00],
        ];

        foreach ($packs as $pack) {
            Pack::create($pack);
        }
    }
}
