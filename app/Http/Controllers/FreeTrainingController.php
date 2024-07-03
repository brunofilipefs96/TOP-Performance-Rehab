<?php

namespace App\Http\Controllers;

use App\Models\FreeTraining;
use App\Models\Room;
use App\Models\TrainingType;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class FreeTrainingController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $this->generateFreeTrainings();

        $currentWeek = Carbon::now()->startOfWeek();
        $selectedWeek = $request->get('week') ? Carbon::parse($request->get('week'))->startOfWeek() : $currentWeek;

        $freeTrainings = FreeTraining::whereBetween('start_date', [$selectedWeek, $selectedWeek->copy()->endOfWeek()])
            ->orderBy('start_date', 'asc')
            ->get()
            ->groupBy(function ($freeTraining) {
                return Carbon::parse($freeTraining->start_date)->format('Y-m-d');
            });

        $daysOfWeek = [];
        for ($date = $selectedWeek->copy(); $date->lte($selectedWeek->copy()->endOfWeek()); $date->addDay()) {
            if ($date->dayOfWeek !== Carbon::SUNDAY) {
                $daysOfWeek[] = $date->format('Y-m-d');
            }
        }

        $showMembershipModal = auth()->user()->hasRole('client') && (!auth()->user()->membership || auth()->user()->membership->status->name !== 'active');

        return view('pages.free_trainings.index', [
            'freeTrainings' => $freeTrainings,
            'currentWeek' => $currentWeek,
            'selectedWeek' => $selectedWeek,
            'daysOfWeek' => $daysOfWeek,
            'showMembershipModal' => $showMembershipModal,
        ]);
    }

    public function enroll(Request $request, FreeTraining $freeTraining)
    {
        $user = auth()->user();

        if ($user->hasRole('client') && (!$user->membership || $user->membership->status->name !== 'active')) {
            return redirect()->route('free_trainings.index')->with('error', 'Você precisa de uma matrícula ativa para se inscrever neste treino.');
        }

        if ($freeTraining->users()->where('user_id', $user->id)->exists()) {
            return redirect()->route('free_trainings.index')->with('error', 'Já está inscrito neste treino livre.');
        }

        if ($freeTraining->users()->count() < $freeTraining->max_students) {
            $freeTraining->users()->attach($user->id);
            return redirect()->route('free_trainings.index')->with('success', 'Inscrição em treino livre realizada com sucesso.');
        } else {
            return redirect()->route('free_trainings.index')->with('error', 'O treino livre está cheio.');
        }
    }

    public function cancel(Request $request, FreeTraining $freeTraining)
    {
        $user = auth()->user();
        $freeTraining->users()->detach($user->id);
        return redirect()->route('free_trainings.index')->with('success', 'Inscrição em treino livre cancelada com sucesso.');
    }

    private function generateFreeTrainings()
    {
        $totalCapacity = setting('total_gym_capacity');
        $freeTrainingPercentage = setting('free_training_percentage');
        $freeTrainingCapacity = ceil($totalCapacity * ($freeTrainingPercentage / 100));

        $currentWeek = Carbon::now()->startOfWeek();
        $nextWeek = $currentWeek->copy()->addWeek();

        for ($date = $currentWeek->copy(); $date->lte($nextWeek->copy()->endOfWeek()); $date->addDay()) {
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

            FreeTraining::firstOrCreate([
                'name' => 'Treino Livre',
                'max_students' => $capacity,
                'start_date' => $startDate,
                'end_date' => $endDate,
            ]);
        }
    }
}
