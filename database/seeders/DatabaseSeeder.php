<?php

namespace Database\Seeders;

use App\Models\Insurance;
use App\Models\Membership;
use App\Models\Room;
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
        $this->call(ClientTypesTableSeeder::class);
        $this->call(SettingsTableSeeder::class);
        $this->call(GymClosureSeeder::class);
        $this->call(RoleSeeder::class);

        //Admin Account
        User::factory()->create([
            'full_name' => 'Admin',
            'birth_date' => '1990-01-01',
            'email' => 'admin@admin.pt',
            'phone_number' => '000000000',
            'gender' => 'male',
            'nif' => '000000000',
            'password' => bcrypt('atec123'),
        ])->roles()->sync([1]);

        //Personal Trainer Account
        User::factory()->create([
            'full_name' => 'Personal Trainer',
            'birth_date' => '1990-01-01',
            'email' => 'pt@pt.pt',
            'phone_number' => '111111111',
            'gender' => 'male',
            'nif' => '111111111',
            'password' => bcrypt('atec123'),
        ])->roles()->sync([2, 4]);

        //Personal Trainer Account 2
        User::factory()->create([
            'full_name' => 'Personal Trainer 2',
            'birth_date' => '1990-01-01',
            'email' => 'pt2@pt.pt',
            'phone_number' => '444444444',
            'gender' => 'male',
            'nif' => '444444444',
            'password' => bcrypt('atec123'),
        ])->roles()->sync([2, 4]);

        //Employee Trainer Account
        User::factory()->create([
            'full_name' => 'Funcionario',
            'birth_date' => '1990-01-01',
            'email' => 'func@func.pt',
            'phone_number' => '222222222',
            'gender' => 'female',
            'nif' => '222222222',
            'password' => bcrypt('atec123'),
        ])->roles()->sync([3, 4]);

        //Client Trainer Account
        User::factory()->create([
            'full_name' => 'Cliente',
            'birth_date' => '1990-01-01',
            'email' => 'cliente@cliente.pt',
            'phone_number' => '333333333',
            'gender' => 'female',
            'nif' => '333333333',
            'password' => bcrypt('atec123'),
        ])->roles()->sync([4]);

        //Client Trainer Account 2
        User::factory()->create([
            'full_name' => 'Cliente 2',
            'birth_date' => '1990-01-01',
            'email' => 'cliente2@cliente.pt',
            'phone_number' => '555555555',
            'gender' => 'male',
            'nif' => '555555555',
            'password' => bcrypt('atec123'),
        ])->roles()->sync([4]);

        $this->call(ProductSeeder::class);
        $this->call(RoomSeeder::class);
        $this->call(StatusSeeder::class);
        $this->call(ServiceSeeder::class);
        $this->call(TrainingTypeSeeder::class);
        $this->call(PackSeeder::class);
        $this->call(SurveySeeder::class);
    }
}
