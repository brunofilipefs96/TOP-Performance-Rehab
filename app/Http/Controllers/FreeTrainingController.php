<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFreeTrainingRequest;
use App\Models\FreeTraining;
use App\Models\GymClosure;
use App\Models\Notification;
use App\Models\NotificationType;
use App\Models\Training;
use App\Models\TrainingType;
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
        $trainingTypes = TrainingType::where('has_personal_trainer', false)->get();
        return view('pages.free-trainings.create', compact('closures', 'trainingTypes'));
    }


    public function store(StoreFreeTrainingRequest $request)
    {
        $validated = $request->validated();

        $startDate = Carbon::createFromFormat('Y-m-d', $validated['start_date']);
        $startTime = Carbon::createFromFormat('H:i', $validated['start_time']);
        $endTime = Carbon::createFromFormat('H:i', $validated['end_time']);
        $duration = 60; // Alterado para 60 minutos

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
                        'training_type_id' => $validated['training_type_id'],
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
            return redirect()->back()->with('error', 'Você precisa de uma matrícula ativa para se inscrever neste treino.');
        }

        if ($freeTraining->users()->where('user_id', $user->id)->exists()) {
            return redirect()->back()->with('error', 'Já está inscrito neste treino livre.');
        }

        $overlappingFreeTrainings = FreeTraining::where('start_date', '<', $freeTraining->end_date)
            ->where('end_date', '>', $freeTraining->start_date)
            ->whereHas('users', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->exists();

        $overlappingTrainings = Training::where('start_date', '<', $freeTraining->end_date)
            ->where('end_date', '>', $freeTraining->start_date)
            ->whereHas('users', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->exists();

        if ($overlappingFreeTrainings || $overlappingTrainings) {
            return redirect()->back()->with('error', 'Já está inscrito noutro treino ou treino livre nesse horário.');
        }

        $today = Carbon::today();
        $trainingTypeId = $freeTraining->training_type_id;

        $membershipPack = $user->membership->packs()
            ->where('quantity_remaining', '>', 0)
            ->where('expiry_date', '>=', $today)
            ->whereHas('trainingType', function ($query) {
                $query->where('has_personal_trainer', false);
            })
            ->orderBy('expiry_date', 'asc')
            ->first();

        if (!$membershipPack) {
            return redirect()->back()->with('error', 'Não possui nenhum pack disponível para se inscrever neste tipo de treino.');
        }

        if ($freeTraining->users()->count() < $freeTraining->max_students) {
            $freeTraining->users()->attach($user->id);

            $membershipPack->pivot->quantity_remaining -= 1;
            $membershipPack->pivot->save();

            return redirect()->back()->with('success', 'Inscreveu-se com sucesso.');
        } else {
            return redirect()->back()->with('error', 'O treino está cheio.');
        }
    }



    public function cancel(Request $request, FreeTraining $freeTraining)
    {
        $user = auth()->user();

        $today = Carbon::today();
        $membershipPack = $user->membership->packs()
            ->where('expiry_date', '>=', $today)
            ->whereHas('trainingType', function ($query) {
                $query->where('has_personal_trainer', false);
            })
            ->orderBy('expiry_date', 'asc')
            ->first();

        if ($membershipPack) {
            $membershipPack->pivot->quantity_remaining += 1;
            $membershipPack->pivot->save();
        }

        $freeTraining->users()->detach($user->id);
        return redirect()->back()->with('success', 'Inscrição em treino livre cancelada com sucesso.');
    }


    public function markPresence(Request $request, FreeTraining $freeTraining)
    {
        $this->authorize('markPresence', $freeTraining);

        $presenceData = $request->input('presence', []);
        $allUsers = $freeTraining->users()->pluck('user_id')->toArray();

        if (array_diff($allUsers, array_keys($presenceData))) {
            return redirect()->route('free-trainings.show', $freeTraining->id)
                ->with('error', 'Todas as presenças devem ser marcadas antes de enviar.');
        }

        foreach ($presenceData as $userId => $presence) {
            $freeTraining->users()->updateExistingPivot($userId, ['presence' => $presence]);
        }

        return redirect()->route('free-trainings.show', $freeTraining->id)
            ->with('success', 'Presenças marcadas com sucesso.');
    }


    public function destroy(FreeTraining $freeTraining)
    {
        $this->authorize('delete', $freeTraining);

        $notificationType = null;
        $notificationMessage = '';
        $url = '';

        if (Carbon::now()->gte($freeTraining->start_date)) {
            return redirect()->route('free-trainings.index')->with('error', 'Não é possível remover treinos que já começaram.');
        }

        if ($freeTraining->users()->count() > 0) {
            foreach ($freeTraining->users as $user) {
                $today = Carbon::today();
                $membershipPack = $user->membership->packs()
                    ->where('expiry_date', '>=', $today)
                    ->whereHas('trainingType', function ($query) {
                        $query->where('has_personal_trainer', false);
                    })
                    ->orderBy('expiry_date', 'asc')
                    ->first();

                if ($membershipPack) {
                    $membershipPack->pivot->quantity_remaining += 1;
                    $membershipPack->pivot->save();
                }

                $notificationType = NotificationType::where('name', 'Treino Cancelado')->firstOrFail();
                $notificationMessage = 'O Treino que se tinha inscrito no dia '.Carbon::parse($freeTraining->start_date)->format('d/m/Y').' foi cancelado. A sua aula foi reembolsada.';

                if ($notificationType) {
                    $notification = Notification::create([
                        'notification_type_id' => $notificationType->id,
                        'message' => $notificationMessage,
                        'url' => $url,
                    ]);

                    $user->notifications()->attach($notification->id);
                }
            }
            $freeTraining->users()->detach();
        }

        $freeTraining->delete();

        if (str_contains(url()->previous(), route('free-trainings.show', $freeTraining->id))) {
            return redirect()->back()->with('success', 'Treino livre eliminado com sucesso.');
        } else {
            return redirect()->back()->with('success', 'Treino livre eliminado com sucesso.');
        }
    }


    public function showMultiDelete(Request $request)
    {
        $this->authorize('multiDelete', FreeTraining::class);

        $query = FreeTraining::where('start_date', '>', Carbon::now())->orderBy('start_date', 'asc');

        if ($request->has('training_type_id') && $request->training_type_id != '') {
            $query->where('training_type_id', $request->training_type_id);
        }

        $freeTrainings = $query->paginate(12);

        return view('pages.free-trainings.multi-delete', compact('freeTrainings'));
    }


    public function multiDelete(Request $request)
    {
        $freeTrainingIds = $request->input('free_trainings', []);

        $notificationType = null;
        $notificationMessage = '';
        $url = '';

        $this->authorize('multiDelete', [FreeTraining::class, $freeTrainingIds]);

        if (!empty($freeTrainingIds)) {
            $freeTrainings = FreeTraining::whereIn('id', $freeTrainingIds)->get();

            foreach ($freeTrainings as $freeTraining) {
                foreach ($freeTraining->users as $user) {
                    $today = Carbon::today();
                    $membershipPack = $user->membership->packs()
                        ->where('expiry_date', '>=', $today)
                        ->whereHas('trainingType', function ($query) {
                            $query->where('has_personal_trainer', false);
                        })
                        ->orderBy('expiry_date', 'asc')
                        ->first();

                    if ($membershipPack) {
                        $membershipPack->pivot->quantity_remaining += 1;
                        $membershipPack->pivot->save();
                    }

                    $notificationType = NotificationType::where('name', 'Treino Cancelado')->firstOrFail();
                    $notificationMessage = 'O Treino que se tinha inscrito no dia '.Carbon::parse($freeTraining->start_date)->format('d/m/Y').' foi cancelado. A sua aula foi reembolsada.';

                    if ($notificationType) {
                        $notification = Notification::create([
                            'notification_type_id' => $notificationType->id,
                            'message' => $notificationMessage,
                            'url' => $url,
                        ]);

                        $user->notifications()->attach($notification->id);
                    }

                    $freeTraining->users()->detach($user->id);
                }
                $freeTraining->delete();
            }
        }

        return redirect()->route('free-trainings.multiDelete')->with('success', 'Treinos livres removidos com sucesso!');
    }

}
