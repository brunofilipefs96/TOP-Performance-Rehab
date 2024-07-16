<?php

namespace App\Http\Controllers;

use App\Models\FreeTraining;
use App\Models\GymClosure;
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

        $type = $request->input('type', 'accompanied'); // Default to 'accompanied'
        $currentWeek = Carbon::now()->startOfWeek();
        $selectedWeek = $request->get('week') ? Carbon::parse($request->get('week'))->startOfWeek() : $currentWeek;

        if ($type === 'free') {
            $this->generateFreeTrainings();

            $trainings = FreeTraining::whereBetween('start_date', [$selectedWeek, $selectedWeek->copy()->endOfWeek()])
                ->orderBy('start_date', 'asc')
                ->get()
                ->groupBy(function ($training) {
                    return Carbon::parse($training->start_date)->format('Y-m-d');
                });
        } else {
            $trainings = Training::whereBetween('start_date', [$selectedWeek, $selectedWeek->copy()->endOfWeek()])
                ->orderBy('start_date', 'asc')
                ->get()
                ->groupBy(function ($training) {
                    return Carbon::parse($training->start_date)->format('Y-m-d');
                });
        }

        $daysOfWeek = [];
        for ($date = $selectedWeek->copy(); $date->lte($selectedWeek->copy()->endOfWeek()); $date->addDay()) {
            if ($date->dayOfWeek !== Carbon::SUNDAY) {
                $daysOfWeek[] = $date->format('Y-m-d');
            }
        }

        $closures = GymClosure::pluck('closure_date')->toArray();

        $showMembershipModal = false;
        if (auth()->user()->hasRole('client') && (!auth()->user()->membership || auth()->user()->membership->status->name !== 'active') && !session()->has('trainings_membership_modal_shown')) {
            session(['trainings_membership_modal_shown' => true]);
            $showMembershipModal = true;
        }

        return view('pages.trainings.index', [
            'trainings' => $trainings,
            'currentWeek' => $currentWeek,
            'selectedWeek' => $selectedWeek,
            'daysOfWeek' => $daysOfWeek,
            'type' => $type,
            'showMembershipModal' => $showMembershipModal,
            'closures' => $closures,
        ]);
    }


    public function create()
    {
        $this->authorize('create', Training::class);
        $rooms = Room::all();
        $trainingTypes = TrainingType::all();
        $personalTrainers = User::all()->filter(function ($user) {
            return $user->roles()->pluck('name')->contains('personal_trainer');
        });

        $closures = GymClosure::pluck('closure_date')->toArray();

        return view('pages.trainings.create', compact('rooms', 'trainingTypes', 'personalTrainers', 'closures'));
    }

    public function store(StoreTrainingRequest $request)
    {
        $validatedData = $request->validated();

        $startDate = Carbon::createFromFormat('Y-m-d H:i', $validatedData['start_date'] . ' ' . $validatedData['start_time']);
        $duration = (int)$validatedData['duration'];
        $endDate = $startDate->copy()->addMinutes($duration);

        if ($request->has('repeat') && $request->repeat) {
            $repeatUntil = Carbon::parse($request->repeat_until);
            $daysOfWeek = collect($request->days_of_week)->map(fn($day) => (int)$day)->all();

            $createdAny = false;
            $currentDate = $startDate->copy();

            while ($currentDate->lte($repeatUntil)) {
                if (in_array($currentDate->dayOfWeek, $daysOfWeek)) {
                    $currentEndDate = $currentDate->copy()->addMinutes($duration);

                    if ($request->passesValidation($currentDate, $currentEndDate, $validatedData['room_id'], $validatedData['personal_trainer_id'], $validatedData['max_students'])) {
                        $trainingData = $validatedData;
                        $trainingData['start_date'] = $currentDate->toDateTimeString();
                        $trainingData['end_date'] = $currentEndDate->toDateTimeString();

                        Training::create($trainingData);
                        $createdAny = true;
                    }
                }
                $currentDate->addDay();
            }

            if (!$createdAny) {
                return redirect()->back()->withErrors(['error' => 'Nenhum treino pôde ser criado dentro dos horários permitidos. Selecione outras datas/horários.']);
            }
        } else {
            if ($request->passesValidation($startDate, $endDate, $validatedData['room_id'], $validatedData['personal_trainer_id'], $validatedData['max_students'])) {
                $validatedData['start_date'] = $startDate->toDateTimeString();
                $validatedData['end_date'] = $endDate->toDateTimeString();

                Training::create($validatedData);
            } else {
                return redirect()->back()->withErrors(['error' => 'O treino deve estar dentro do horário permitido e respeitar todas as validações. Selecione outras datas/horários.']);
            }
        }

        return redirect()->route('trainings.index')->with('success', 'Treino(s) criado(s) com sucesso.');
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
        $personalTrainers = User::all()->filter(function ($user) {
            return $user->roles()->pluck('name')->contains('personal_trainer');
        });

        $closures = GymClosure::pluck('closure_date')->toArray();

        return view('pages.trainings.edit', compact('training', 'rooms', 'trainingTypes', 'personalTrainers', 'closures'));
    }

    public function update(UpdateTrainingRequest $request, Training $training)
    {
        $validatedData = $request->validated();

        $startDate = Carbon::createFromFormat('Y-m-d H:i', $validatedData['start_date'] . ' ' . $validatedData['start_time']);
        $duration = (int)$validatedData['duration'];
        $endDate = $startDate->copy()->addMinutes($duration);

        $startTime = $startDate->format('H:i');
        $endTime = $endDate->format('H:i');
        $horarioInicio = setting('horario_inicio', '06:00');
        $horarioFim = setting('horario_fim', '23:59');

        if ($startTime < $horarioInicio || $endTime > $horarioFim) {
            return redirect()->back()->withErrors(['error' => 'O treino deve estar dentro do horário permitido.']);
        }

        if ($training->users()->count() > 0) {
            return redirect()->route('trainings.index')->with('error', 'Não é possível editar um treino com alunos inscritos.');
        }

        $validatedData['start_date'] = $startDate->toDateTimeString();
        $validatedData['end_date'] = $endDate->toDateTimeString();

        $training->update($validatedData);

        return redirect()->route('trainings.index')->with('success', 'Treino atualizado com sucesso.');
    }


    public function destroy(Training $training)
    {
        $this->authorize('delete', $training);

        if ($training->users()->count() > 0) {
            foreach ($training->users as $user) {
                $today = Carbon::today();
                $membershipPack = $user->membership->packs()
                    ->where('expiry_date', '>=', $today)
                    ->where('has_personal_trainer', true)
                    ->orderBy('expiry_date', 'asc')
                    ->first();

                if ($membershipPack) {
                    $membershipPack->pivot->quantity_remaining += 1;
                    $membershipPack->pivot->save();
                }

                $training->users()->detach($user->id);
            }
        }

        $training->delete();
        return redirect()->route('trainings.index')->with('success', 'Treino eliminado com sucesso.');
    }

    public function enroll(Request $request, Training $training)
    {
        $this->authorize('enroll', $training);
        $user = auth()->user();

        if ($user->hasRole('client') && (!$user->membership || $user->membership->status->name !== 'active')) {
            return redirect()->route('trainings.index')->with('error', 'Necessita de ter uma matrícula ativa para se inscrever neste treino.');
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
            return redirect()->route('trainings.index')->with('error', 'Já está inscrito noutro treino nesse horário.');
        }

        $today = Carbon::today();
        $membershipPack = $user->membership->packs()
            ->where('quantity_remaining', '>', 0)
            ->where('expiry_date', '>=', $today)
            ->where('has_personal_trainer', true)
            ->orderBy('expiry_date', 'asc')
            ->first();

        if (!$membershipPack) {
            return redirect()->route('trainings.index')->with('error', 'Não possui nenhum pack de aulas acompanhadas disponível para se inscrever.');
        }

        if ($training->users()->count() < $training->max_students) {
            $training->users()->attach($user->id);

            $membershipPack->pivot->quantity_remaining -= 1;
            $membershipPack->pivot->save();

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

            $today = Carbon::today();
            $membershipPack = $user->membership->packs()
                ->where('expiry_date', '>=', $today)
                ->where('has_personal_trainer', true)
                ->orderBy('expiry_date', 'asc')
                ->first();
            if ($membershipPack) {
                $membershipPack->pivot->quantity_remaining += 1;
                $membershipPack->pivot->save();
            }

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

    public function showMultiDelete(Request $request)
    {
        $this->authorize('viewAny', Training::class);

        $user = auth()->user();
        $isPersonalTrainer = $user->roles->contains('name', 'personal_trainer');
        $isAdmin = $user->roles->contains('name', 'admin');

        $query = Training::where('start_date', '>', Carbon::now())->orderBy('start_date', 'asc');

        if ($isAdmin) {
            $personalTrainers = User::whereHas('roles', function ($query) {
                $query->where('name', 'personal_trainer');
            })->get();
        } else {
            $query->where('personal_trainer_id', $user->id);
            $personalTrainers = collect();
        }

        if ($request->has('training_type_id') && $request->training_type_id != '') {
            $query->where('training_type_id', $request->training_type_id);
        }

        if ($isAdmin && $request->has('personal_trainer_id') && $request->personal_trainer_id != '') {
            $query->where('personal_trainer_id', $request->personal_trainer_id);
        }

        $trainings = $query->paginate(12);
        $trainingTypes = TrainingType::all();

        return view('pages.trainings.multi-delete', compact('trainings', 'personalTrainers', 'trainingTypes'));
    }

    public function multiDelete(Request $request)
    {
        $trainingIds = $request->input('trainings', []);

        $this->authorize('multiDelete', [Training::class, $trainingIds]);

        if (!empty($trainingIds)) {
            $trainings = Training::whereIn('id', $trainingIds)->get();

            foreach ($trainings as $training) {
                foreach ($training->users as $user) {
                    $today = Carbon::today();
                    $membershipPack = $user->membership->packs()
                        ->where('expiry_date', '>=', $today)
                        ->where('has_personal_trainer', true)
                        ->orderBy('expiry_date', 'asc')
                        ->first();

                    if ($membershipPack) {
                        $membershipPack->pivot->quantity_remaining += 1;
                        $membershipPack->pivot->save();
                    }

                    $training->users()->detach($user->id);
                }
                $training->delete();
            }
        }

        return redirect()->route('trainings.index')->with('success', 'Treinos removidos com sucesso!');
    }
}
