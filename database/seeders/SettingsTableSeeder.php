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
            ['key' => 'capacidade_maxima', 'value' => '20'],
            ['key' => 'horario_inicio_semanal', 'value' => '06:00'],
            ['key' => 'horario_fim_semanal', 'value' => '23:30'],
            ['key' => 'horario_inicio_sabado', 'value' => '08:00'],
            ['key' => 'horario_fim_sabado', 'value' => '18:00'],
            ['key' => 'telemovel', 'value' => '910000000'],
            ['key' => 'email', 'value' => 'ginasiotop@email.pt'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(['key' => $setting['key']], ['value' => $setting['value']]);
        }
    }
}
