<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Room::factory()->create([
            'name' => 'Funcional',
            'capacity' => 5,
        ]);

        Room::factory()->create([
            'name' => 'Pilates',
            'capacity' => 10,
        ]);

    }
}
