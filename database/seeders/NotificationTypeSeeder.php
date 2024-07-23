<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NotificationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $notificationTypes = [
            ['name' => 'Matrícula Aprovada'],
            ['name' => 'Matrícula Negada'],
            ['name' => 'Matrícula Congelada'],
            ['name' => 'Matrícula Expirada'],
            ['name' => 'Seguro Aprovado'],
            ['name' => 'Seguro Negado'],
            ['name' => 'Seguro Congelado'],
            ['name' => 'Seguro Expirado'],
            ['name' => 'Renovação Aprovada'],
            ['name' => 'Renovação Negada'],
            ['name' => 'Matrícula Submetida'],
            ['name' => 'Seguro Submetido'],
            ['name' => 'Renovação de Matrícula Submetida'],
            ['name' => 'Renovação de Seguro Submetida']
        ];


        DB::table('notification_types')->insert($notificationTypes);
    }
}
