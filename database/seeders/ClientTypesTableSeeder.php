<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ClientType;

class ClientTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clientTypes = [
            ['name' => 'admin_top_paddle'],
            ['name' => 'employee_top_paddle'],
            ['name' => 'client_top_paddle'],
        ];

        foreach ($clientTypes as $type) {
            ClientType::updateOrCreate(['name' => $type['name']]);
        }
    }
}

