<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Console\Scheduling\Schedule;

// Comando para exibir uma citação inspiradora a cada hora
Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Comando para gerar treinos gratuitos aos domingos à meia-noite
Artisan::command('generate:free-trainings', function () {
    // Lógica do comando generate:free-trainings
})->describe('Generate free trainings every Sunday at midnight');

// Comando para atualizar o status das memberships e insurances
Artisan::command('memberships:update-status', function () {
    Artisan::call('memberships:update-status');
})->describe('Update the status of memberships and insurances with end_date less than the current date');

// Agendamento das tarefas
$schedule = app(Schedule::class);

// Agendando o comando memberships:update-status para rodar diariamente à meia-noite
$schedule->command('memberships:update-status')->dailyAt('00:00');

// Agendando o comando generate:free-trainings para rodar aos domingos à meia-noite
$schedule->command('generate:free-trainings')->sundays()->at('00:00');

// Outros agendamentos, se necessário
