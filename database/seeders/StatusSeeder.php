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
            ['name' => 'rejected'],
            ['name' => 'frozen'],
            ['name' => 'pending_payment'],
            ['name' => 'paid'],
            ['name' => 'canceled'],
            ['name' => 'delivered'],
            ['name' => 'returned'],
            ['name' => 'refunded'],
        ];

        DB::table('statuses')->insert($statuses);
    }
}
