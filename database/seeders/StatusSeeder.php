<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            ['name' => 'pending'],
            ['name' => 'active'],
            ['name' => 'inactive'],
            ['name' => 'suspended'],
            ['name' => 'cancelled'],
            ['name' => 'no_exists'],
        ];

        DB::table('statuses')->insert($statuses);
    }
}
