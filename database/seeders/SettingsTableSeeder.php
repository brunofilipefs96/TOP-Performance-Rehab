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
            ['key' => 'percentagem_aulas_livres', 'value' => '40'],
            ['key' => 'horario_inicio', 'value' => '06:00'],
            ['key' => 'horario_fim', 'value' => '23:59'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(['key' => $setting['key']], ['value' => $setting['value']]);
        }
    }
}
