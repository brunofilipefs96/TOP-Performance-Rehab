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
        $this->call(RoleSeeder::class);

        //Admin Account
        User::factory()->create([
            'full_name' => 'Admin',
            'birth_date' => '1990-01-01',
            'email' => 'admin@admin.pt',
            'phone_number' => '000000000',
            'gender' => 'male',
            'nif' => '000000000',
            'cc_number' => '000000000',
            'password' => bcrypt('atec123'),
        ])->roles()->sync([1]);

        User::factory()->create([
            'full_name' => 'Personal Trainer',
            'birth_date' => '1990-01-01',
            'email' => 'pt@pt.pt',
            'phone_number' => '111111111',
            'gender' => 'male',
            'nif' => '111111111',
            'cc_number' => '111111111',
            'password' => bcrypt('atec123'),
        ])->roles()->sync([2]);

        User::factory()->create([
            'full_name' => 'Funcionario',
            'birth_date' => '1990-01-01',
            'email' => 'func@func.pt',
            'phone_number' => '222222222',
            'gender' => 'female',
            'nif' => '222222222',
            'cc_number' => '222222222',
            'password' => bcrypt('atec123'),
        ])->roles()->sync([3]);

        User::factory()->create([
            'full_name' => 'Cliente',
            'birth_date' => '1990-01-01',
            'email' => 'cliente@cliente.pt',
            'phone_number' => '333333333',
            'gender' => 'female',
            'nif' => '333333333',
            'cc_number' => '333333333',
            'password' => bcrypt('atec123'),
        ])->roles()->sync([4]);

        $this->call(ProductSeeder::class);
        $this->call(RoomSeeder::class);
        $this->call(TrainingTypeSeeder::class);
        $this->call(PackSeeder::class);
        $this->call(SurveySeeder::class);
    }
}
