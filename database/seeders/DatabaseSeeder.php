<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //User::factory(10)->create();

        //Admin Account
        User::factory()->create([
            'full_name' => 'Admin',
            'birth_date' => '1990-01-01',
            'email' => 'admin@admin.pt',
            'phone_number' => '000000000',
            'gender' => 'male',
            'nif' => '000000000',
            'cc_number' => '000000000',
            'password' => bcrypt('admin12345'),
        ]);

        $this->call(RoleSeeder::class);
    }
}
