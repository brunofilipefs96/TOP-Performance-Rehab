<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Training;
use App\Http\Requests\StoreTrainingRequest;
use App\Http\Requests\UpdateTrainingRequest;
use App\Models\TrainingType;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class TrainingController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $this->authorize('viewAny', Training::class);

        $currentWeek = Carbon::now()->startOfWeek();
        $selectedWeek = $request->get('week') ? Carbon::parse($request->get('week'))->startOfWeek() : $currentWeek;

        if (!(auth()->user()->hasRole('admin') || auth()->user()->hasRole('personal_trainer')) && $selectedWeek->lt($currentWeek)) {
            $selectedWeek = $currentWeek;
        }

        $trainings = Training::whereBetween('start_date', [$selectedWeek, $selectedWeek->copy()->endOfWeek()])
            ->orderBy('start_date', 'asc')
            ->get()
            ->groupBy(function ($training) {
                return Carbon::parse($training->start_date)->format('Y-m-d');
            });

        $daysOfWeek = [];
        for ($date = $selectedWeek->copy(); $date->lte($selectedWeek->copy()->endOfWeek()); $date->addDay()) {
            $daysOfWeek[] = $date->format('Y-m-d');
        }

        $showMembershipModal = false;
        if (auth()->user()->hasRole('client') && (!auth()->user()->membership || auth()->user()->membership->status->name !== 'active') && !session()->has('membership_modal_shown')) {
            session(['membership_modal_shown' => true]);
            $showMembershipModal = true;
        }

        return view('pages.trainings.index', [
            'trainings' => $trainings,
            'currentWeek' => $currentWeek,
            'selectedWeek' => $selectedWeek,
            'daysOfWeek' => $daysOfWeek,
            'showMembershipModal' => $showMembershipModal,
        ]);
    }

    public function create()
    {
        $this->authorize('create', Training::class);
        $rooms = Room::all();
        $trainingTypes = TrainingType::all();
        $personalTrainers = User::all()->filter(function($user) {
            return $user->hasRole('personal_trainer');
        });

        return view('pages.trainings.create', compact('rooms', 'trainingTypes', 'personalTrainers'));
    }

    public function store(StoreTrainingRequest $request)
    {
        $validatedData = $request->validated();

        $startDate = Carbon::createFromFormat('Y-m-d H:i', $validatedData['start_date'] . ' ' . $validatedData['start_time']);
        $duration = (int) $validatedData['duration'];
        $endDate = $startDate->copy()->addMinutes($duration);

        if ($request->has('repeat') && $request->repeat) {
            $repeatUntil = Carbon::parse($request->repeat_until);
            $daysOfWeek = collect($request->days_of_week)->map(fn($day) => (int)$day)->all();

            while ($startDate->lte($repeatUntil)) {
                if (in_array($startDate->dayOfWeek, $daysOfWeek)) {
                    if (Carbon::today()->eq($startDate->copy()->startOfDay()) && $startDate->lt(Carbon::now())) {
                        $startDate = $startDate->copy()->addDay();
                        $endDate = $startDate->copy()->addMinutes($duration);
                        continue;
                    }

                    $trainingData = $validatedData;
                    $trainingData['start_date'] = $startDate->toDateTimeString();
                    $trainingData['end_date'] = $endDate->toDateTimeString();
                    Training::create($trainingData);
                }

                $nextDay = collect($daysOfWeek)->map(function ($day) use ($startDate) {
                    return $startDate->copy()->next($day)->setTime($startDate->hour, $startDate->minute);
                })->filter(function ($date) use ($repeatUntil) {
                    return $date->lte($repeatUntil);
                })->sort()->first();

                if ($nextDay) {
                    $startDate = $nextDay;
                    $endDate = $startDate->copy()->addMinutes($duration);
                } else {
                    break;
                }
            }
        } else {
            $validatedData['start_date'] = $startDate->toDateTimeString();
            $validatedData['end_date'] = $endDate->toDateTimeString();
            Training::create($validatedData);
        }

        return redirect()->route('trainings.index')->with('success', 'Treino criado com sucesso.');
    }

    public function show(Training $training)
    {
        $this->authorize('view', $training);
        $users = $training->users;
        return view('pages.trainings.show', ['training' => $training, 'users' => $users]);
    }

    public function edit(Training $training)
    {
        $this->authorize('update', $training);
        $rooms = Room::all();
        $trainingTypes = TrainingType::all();
        $personalTrainers = User::all()->filter(function($user) {
            return $user->hasRole('personal_trainer');
        });

        return view('pages.trainings.edit', compact('training', 'rooms', 'trainingTypes', 'personalTrainers'));
    }

    public function update(UpdateTrainingRequest $request, Training $training)
    {
        $validatedData = $request->validated();

        $startDate = Carbon::createFromFormat('Y-m-d H:i', $validatedData['start_date'] . ' ' . $validatedData['start_time']);
        $duration = (int) $validatedData['duration'];
        $endDate = $startDate->copy()->addMinutes($duration);

        $validatedData['start_date'] = $startDate->toDateTimeString();
        $validatedData['end_date'] = $endDate->toDateTimeString();

        $training->update($validatedData);

        return redirect()->route('trainings.index')->with('success', 'Treino atualizado com sucesso.');
    }

    public function destroy(Training $training)
    {
        $this->authorize('delete', $training);
        $training->delete();
        return redirect()->route('trainings.index')->with('success', 'Training deleted successfully.');
    }

    public function enroll(Request $request, Training $training)
    {
        $this->authorize('enroll', $training);
        $user = auth()->user();

        if (!$user->membership || $user->membership->status->name !== 'active') {
            return redirect()->route('trainings.index')->with('error', 'Você precisa de uma matrícula ativa para se inscrever neste treino.');
        }

        if ($training->users()->where('user_id', $user->id)->exists()) {
            return redirect()->route('trainings.index')->with('error', 'Já se encontra inscrito neste treino.');
        }

        if ($training->personal_trainer_id == $user->id) {
            return redirect()->route('trainings.index')->with('error', 'Não pode inscrever-se no seu próprio treino.');
        }

        $overlappingTrainings = Training::where('start_date', '<', $training->end_date)
            ->where('end_date', '>', $training->start_date)
            ->whereHas('users', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->exists();

        if ($overlappingTrainings) {
            return redirect()->route('trainings.index')->with('error', 'Já está inscrito em outro treino nesse horário.');
        }

        if ($training->users()->count() < $training->max_students) {
            $training->users()->attach($user->id);
            return redirect()->route('trainings.index')->with('success', 'Inscreveu-se com sucesso.');
        } else {
            return redirect()->route('trainings.index')->with('error', 'O treino está cheio.');
        }
    }

    public function cancel(Request $request, Training $training)
    {
        $this->authorize('cancel', $training);

        $user = auth()->user();
        $startTime = Carbon::parse($training->start_date);
        $now = Carbon::now();
        $differenceInHours = $now->diffInHours($startTime, false);

        if ($differenceInHours > 12) {
            $training->users()->detach($user->id);
            return redirect()->route('trainings.index')->with('success', 'Inscrição cancelada com sucesso. Você não será cobrado.');
        } elseif ($differenceInHours <= 12 && $differenceInHours > 0) {
            $training->users()->updateExistingPivot($user->id, ['presence' => false]);
            return redirect()->route('trainings.index')->with('success', 'Inscrição cancelada com sucesso. A presença será marcada como ausente e você será cobrado.');
        } else {
            return redirect()->route('trainings.index')->with('error', 'Não é possível cancelar a inscrição após o início do treino.');
        }
    }



    public function markPresence(Request $request, Training $training)
    {
        $this->authorize('markPresence', $training);

        $presenceData = $request->input('presence', []);
        $allUsers = $training->users()->pluck('user_id')->toArray();

        if (array_diff($allUsers, array_keys($presenceData))) {
            return redirect()->route('trainings.show', $training->id)
                ->with('error', 'Todas as presenças devem ser marcadas antes de enviar.');
        }

        foreach ($presenceData as $userId => $presence) {
            $training->users()->updateExistingPivot($userId, ['presence' => $presence]);
        }

        return redirect()->route('trainings.show', $training->id)
            ->with('success', 'Presenças marcadas com sucesso.');
    }

    public function multiDelete(Request $request)
    {
        $trainingIds = $request->input('trainings', []);

        $this->authorize('multiDelete', [Training::class, $trainingIds]);

        $user = auth()->user();

        if (!empty($trainingIds)) {
            $trainings = Training::whereIn('id', $trainingIds)->get();

            foreach ($trainings as $training) {
                if ($user->hasRole('admin') || $training->personal_trainer_id == $user->id) {
                    $training->delete();
                } else {
                    return redirect()->route('trainings.index')->with('error', 'Você não tem permissão para remover um ou mais treinos dos treinos selecionados.');
                }
            }
        }

        return redirect()->route('trainings.index')->with('success', 'Treinos removidos com sucesso!');
    }
}
