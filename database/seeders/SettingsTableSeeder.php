<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            ['key' => 'taxa_inscricao', 'value' => '50'],
            ['key' => 'taxa_seguro', 'value' => '20'],
            ['key' => 'capacidade_maxima', 'value' => '15'],
            ['key' => 'horario_inicio_semanal', 'value' => '07:00'],
            ['key' => 'horario_fim_semanal', 'value' => '22:00'],
            ['key' => 'horario_inicio_sabado', 'value' => '08:00'],
            ['key' => 'horario_fim_sabado', 'value' => '18:00'],
            ['key' => 'telemovel', 'value' => '910000000'],
            ['key' => 'email', 'value' => 'ginasiotop@email.pt'],
            ['key' => 'top_paddle_client_membership_discount', 'value' => '10'],
            ['key' => 'top_paddle_client_insurance_discount', 'value' => '10'],
            ['key' => 'top_paddle_client_trainings_discount', 'value' => '10'],
            ['key' => 'top_paddle_admin_membership_discount', 'value' => '100'],
            ['key' => 'top_paddle_admin_insurance_discount', 'value' => '100'],
            ['key' => 'top_paddle_admin_funcional_training_discount', 'value' => '100'],
            ['key' => 'top_paddle_admin_personal_training_trainings_discount', 'value' => '30'],
            ['key' => 'top_paddle_employee_membership_discount', 'value' => '100'],
            ['key' => 'top_paddle_employee_insurance_discount', 'value' => '100'],
            ['key' => 'top_paddle_employee_funcional_training_discount', 'value' => '45'],
            ['key' => 'top_paddle_employee_personal_training_trainings_discount', 'value' => '30'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(['key' => $setting['key']], ['value' => $setting['value']]);
        }
    }
}
