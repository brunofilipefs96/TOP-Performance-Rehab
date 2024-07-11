<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFreeTrainingRequest;
use App\Models\FreeTraining;
use App\Models\GymClosure;
use App\Models\Training;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class FreeTrainingController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $user = auth()->user();
        $currentWeek = Carbon::now()->startOfWeek();
        $selectedWeek = $request->query('week') ? Carbon::parse($request->query('week'))->startOfWeek() : $currentWeek;
        $selectedDay = $request->query('day') ? Carbon::parse($request->query('day')) : null;

        if ($user->hasRole('client')) {
            if ($selectedWeek->lt($currentWeek)) {
                $selectedWeek = $currentWeek;
            } elseif ($selectedWeek->gt($currentWeek->copy()->addWeek())) {
                $selectedWeek = $currentWeek->copy()->addWeek();
            }
        }

        if ($selectedDay === null) {
            if ($selectedWeek->eq($currentWeek)) {
                $selectedDay = Carbon::now();
            } else {
                $selectedDay = $selectedWeek->copy()->startOfWeek();
            }
        }

        if ($selectedDay->dayOfWeek == Carbon::SUNDAY) {
            $selectedDay = $selectedDay->addDay();
        }

        Session::put('selected_week', $selectedWeek);
        Session::put('selected_day', $selectedDay);

        $freeTrainings = FreeTraining::whereBetween('start_date', [$selectedWeek, $selectedWeek->copy()->endOfWeek()])
            ->orderBy('start_date', 'asc')
            ->get()
            ->groupBy(function ($freeTraining) {
                return Carbon::parse($freeTraining->start_date)->format('Y-m-d');
            });

        $daysOfWeek = [];
        for ($date = $selectedWeek->copy()->startOfWeek(); $date->lte($selectedWeek->copy()->endOfWeek()); $date->addDay()) {
            $daysOfWeek[] = $date->format('Y-m-d');
        }

        $showMembershipModal = false;
        if ($user->hasRole('client') && (!auth()->user()->membership || auth()->user()->membership->status->name !== 'active') && !session()->has('free_trainings_membership_modal_shown')) {
            session(['free_trainings_membership_modal_shown' => true]);
            $showMembershipModal = true;
        }

        return view('pages.trainings.index', [
            'freeTrainings' => $freeTrainings,
            'currentWeek' => $currentWeek,
            'selectedWeek' => $selectedWeek,
            'daysOfWeek' => $daysOfWeek,
            'selectedDay' => $selectedDay,
            'showMembershipModal' => $showMembershipModal,
        ]);
    }

    public function create()
    {
        $closures = GymClosure::pluck('closure_date')->toArray();
        return view('pages.free-trainings.create', compact('closures'));
    }

    public function store(StoreFreeTrainingRequest $request)
    {
        $validated = $request->validated();

        $startDate = Carbon::createFromFormat('Y-m-d', $validated['start_date']);
        $startTime = Carbon::createFromFormat('H:i', $validated['start_time']);
        $endTime = Carbon::createFromFormat('H:i', $validated['end_time']);
        $duration = 30;

        $daysOfWeek = $request->input('days_of_week', []);
        $repeatUntil = $request->input('repeat_until');

        $horarioInicioSemanal = setting('horario_inicio_semanal', '06:00');
        $horarioFimSemanal = setting('horario_fim_semanal', '23:59');
        $horarioInicioSabado = setting('horario_inicio_sabado', '08:00');
        $horarioFimSabado = setting('horario_fim_sabado', '18:00');

        $createTrainings = function ($date) use ($validated, $duration, $horarioInicioSemanal, $horarioFimSemanal, $horarioInicioSabado, $horarioFimSabado) {
            $startTime = Carbon::createFromFormat('H:i', $validated['start_time']);
            $endTime = Carbon::createFromFormat('H:i', $validated['end_time']);
            $horarioInicio = ($date->dayOfWeek === Carbon::SATURDAY) ? $horarioInicioSabado : $horarioInicioSemanal;
            $horarioFim = ($date->dayOfWeek === Carbon::SATURDAY) ? $horarioFimSabado : $horarioFimSemanal;

            while ($startTime->lessThan($endTime)) {
                $startDateTime = $date->copy()->setTimeFrom($startTime);
                $endDateTime = $startDateTime->copy()->addMinutes($duration);

                if ($startDateTime->format('H:i') < $horarioInicio || $endDateTime->format('H:i') > $horarioFim) {
                    $startTime->addMinutes($duration);
                    continue;
                }

                $existingFreeTraining = FreeTraining::where(function ($query) use ($startDateTime, $endDateTime) {
                    $query->where(function ($query) use ($startDateTime, $endDateTime) {
                        $query->where('start_date', '<=', $startDateTime)
                            ->where('end_date', '>', $startDateTime);
                    })->orWhere(function ($query) use ($startDateTime, $endDateTime) {
                        $query->where('start_date', '<', $endDateTime)
                            ->where('end_date', '>=', $endDateTime);
                    })->orWhere(function ($query) use ($startDateTime, $endDateTime) {
                        $query->where('start_date', '>=', $startDateTime)
                            ->where('start_date', '<', $endDateTime);
                    });
                })->exists();

                if (!$existingFreeTraining) {
                    FreeTraining::create([
                        'name' => 'Treino Livre',
                        'max_students' => $validated['max_students'],
                        'start_date' => $startDateTime->toDateTimeString(),
                        'end_date' => $endDateTime->toDateTimeString(),
                    ]);
                }

                $startTime->addMinutes($duration);
            }
        };

        if ($request->has('repeat') && $repeatUntil) {
            $repeatUntilDate = Carbon::createFromFormat('Y-m-d', $repeatUntil);
            $currentDate = $startDate->copy();

            while ($currentDate->lessThanOrEqualTo($repeatUntilDate)) {
                if (in_array($currentDate->dayOfWeek, $daysOfWeek)) {
                    $createTrainings($currentDate);
                }
                $currentDate->addDay();
            }
        } else {
            $createTrainings($startDate);
        }

        return redirect()->route('free-trainings.index')->with('success', 'Treinos livres criados com sucesso.');
    }





    public function show(FreeTraining $freeTraining)
    {
        $this->authorize('view', $freeTraining);
        return view('pages.free-trainings.show', compact('freeTraining'));
    }

    public function changeWeek(Request $request)
    {
        $direction = $request->input('direction');
        $selectedWeek = Session::get('selected_week', Carbon::now()->startOfWeek());

        if ($direction === 'previous') {
            $selectedWeek = $selectedWeek->subWeek();
        } elseif ($direction === 'next') {
            $selectedWeek = $selectedWeek->addWeek();
        }

        $selectedDay = $selectedWeek->copy()->startOfWeek();

        Session::put('selected_week', $selectedWeek);
        Session::put('selected_day', $selectedDay);
        return redirect()->route('free-trainings.index', ['week' => $selectedWeek->format('Y-m-d')]);
    }

    public function selectDay(Request $request, $day)
    {
        $selectedDay = Carbon::parse($day);
        Session::put('selected_day', $selectedDay);
        return redirect()->route('free-trainings.index', ['day' => $selectedDay->format('Y-m-d'), 'week' => $selectedDay->startOfWeek()->format('Y-m-d')]);
    }

    public function enroll(Request $request, FreeTraining $freeTraining)
    {
        $user = auth()->user();

        if ($user->hasRole('client') && (!$user->membership || $user->membership->status->name !== 'active')) {
            return redirect()->route('free-trainings.index')->with('error', 'Você precisa de uma matrícula ativa para se inscrever neste treino.');
        }

        if ($freeTraining->users()->where('user_id', $user->id)->exists()) {
            return redirect()->route('free-trainings.index')->with('error', 'Já está inscrito neste treino livre.');
        }

        if ($freeTraining->users()->count() < $freeTraining->max_students) {
            $membershipPack = $user->membership->packs()
                ->where('quantity_remaining', '>', 0)
                ->where('expiry_date', '>=', Carbon::today())
                ->where('has_personal_trainer', false)
                ->orderBy('expiry_date', 'asc')
                ->first();

            if ($membershipPack) {
                $membershipPack->pivot->quantity_remaining -= 1;
                $membershipPack->pivot->save();
                $freeTraining->users()->attach($user->id);
                return redirect()->route('free-trainings.index')->with('success', 'Inscrição em treino livre realizada com sucesso.');
            } else {
                return redirect()->route('free-trainings.index')->with('error', 'Você não possui packs disponíveis.');
            }
        } else {
            return redirect()->route('free-trainings.index')->with('error', 'O treino livre está cheio.');
        }
    }

    public function cancel(Request $request, FreeTraining $freeTraining)
    {
        $user = auth()->user();

        $membershipPack = $user->membership->packs()
            ->where('expiry_date', '>=', Carbon::today())
            ->where('has_personal_trainer', false)
            ->orderBy('expiry_date', 'asc')
            ->first();

        if ($membershipPack) {
            $membershipPack->pivot->quantity_remaining += 1;
            $membershipPack->pivot->save();
        }

        $freeTraining->users()->detach($user->id);
        return redirect()->route('free-trainings.index')->with('success', 'Inscrição em treino livre cancelada com sucesso.');
    }

    public function destroy(FreeTraining $freeTraining)
    {
        $this->authorize('delete', $freeTraining);

        if (Carbon::now()->gte($freeTraining->start_date)) {
            return redirect()->route('free-trainings.index')->with('error', 'Não é possível remover treinos que já começaram.');
        }

        if ($freeTraining->users()->count() > 0) {
            foreach ($freeTraining->users as $user) {
                $today = Carbon::today();
                $membershipPack = $user->membership->packs()
                    ->where('expiry_date', '>=', $today)
                    ->where('has_personal_trainer', false)
                    ->orderBy('expiry_date', 'asc')
                    ->first();

                if ($membershipPack) {
                    $membershipPack->pivot->quantity_remaining += 1;
                    $membershipPack->pivot->save();
                }

                $freeTraining->users()->detach($user->id);
            }
        }

        $freeTraining->delete();
        return redirect()->route('free-trainings.index')->with('success', 'Treino livre eliminado com sucesso.');
    }
}
