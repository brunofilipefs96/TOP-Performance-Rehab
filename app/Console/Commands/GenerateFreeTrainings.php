<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\FreeTraining;
use Carbon\Carbon;

class GenerateFreeTrainings extends Command
{
    protected $signature = 'generate:free-trainings';
    protected $description = 'Generate free trainings for the current and next week';

    public function handle()
    {
        $this->generateFreeTrainings(Carbon::now()->startOfWeek());
        $this->generateFreeTrainings(Carbon::now()->startOfWeek()->addWeek());
        $this->info('Free trainings generated successfully.');
    }

    private function generateFreeTrainings(Carbon $startOfWeek)
    {
        $totalCapacity = setting('capacidade_maxima');
        $freeTrainingPercentage = setting('percentagem_aulas_livres');
        $freeTrainingCapacity = ceil($totalCapacity * ($freeTrainingPercentage / 100));

        for ($date = $startOfWeek->copy(); $date->lte($startOfWeek->copy()->endOfWeek()); $date->addDay()) {
            if ($date->dayOfWeek !== Carbon::SUNDAY) {
                $this->createDailyFreeTrainings($date, $freeTrainingCapacity);
            }
        }
    }

    private function createDailyFreeTrainings(Carbon $date, $capacity)
    {
        $horarioInicio = Carbon::createFromFormat('H:i', setting('horario_inicio', '06:00'));
        $horarioFim = Carbon::createFromFormat('H:i', setting('horario_fim', '23:59'));
        $interval = 30;

        for ($time = $horarioInicio->copy(); $time->lt($horarioFim); $time->addMinutes($interval)) {
            $startDate = $date->copy()->setTimeFromTimeString($time->format('H:i'));
            $endDate = $startDate->copy()->addMinutes($interval);

            if (!FreeTraining::where('start_date', $startDate)->exists()) {
                FreeTraining::create([
                    'name' => 'Treino Livre',
                    'max_students' => $capacity,
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                ]);
            }
        }
    }
}
