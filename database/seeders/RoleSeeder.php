<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['name' => 'admin', 'priority' => 1],
            ['name' => 'personal_trainer', 'priority' => 2],
            ['name' => 'employee', 'priority' => 3],
            ['name' => 'client', 'priority' => 4],
        ];

        DB::table('roles')->insert($roles);
    }
}
