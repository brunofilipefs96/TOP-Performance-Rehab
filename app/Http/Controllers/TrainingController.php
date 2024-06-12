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

    public function index()
    {
        $this->authorize('viewAny', Training::class);
        $trainings = Training::orderBy('id', 'desc')->paginate(12);
        $trainingTypes = TrainingType::all();
        return view('pages.trainings.index', ['trainings' => $trainings, 'trainingTypes' => $trainingTypes]);
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

        $currentEnrolled = $training->users()->count();
        if ($validatedData['max_students'] < $currentEnrolled) {
            return redirect()->back()->withErrors(['max_students' => 'O número máximo de alunos não pode ser menor do que o número de alunos já inscritos.'])->withInput();
        }

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
        $user = auth()->user();

        if ($training->users()->where('user_id', $user->id)->exists()) {
            return redirect()->route('trainings.index')->with('error', 'Já se encontra inscrito neste treino.');
        }

        if ($training->personal_trainer_id == $user->id) {
            return redirect()->route('trainings.index')->with('error', 'Não pode inscrever-se no seu próprio treino.');
        }

        if ($training->users()->count() < $training->max_students) {
            $training->users()->attach($user->id, ['presence' => true]); // Ensure presence is true when enrolling
            return redirect()->route('trainings.index')->with('success', 'Inscreveu-se com sucesso.');
        } else {
            return redirect()->route('trainings.index')->with('error', 'O treino está cheio.');
        }
    }

    public function cancel(Request $request, Training $training)
    {
        $user = auth()->user();

        if (!$training->users()->where('user_id', $user->id)->exists()) {
            return redirect()->route('trainings.index')->with('error', 'Você não está inscrito neste treino.');
        }

        $startTime = Carbon::parse($training->start_date);
        $now = Carbon::now();
        $differenceInHours = $startTime->diffInHours($now);

        if ($differenceInHours > 12) {
            $training->users()->detach($user->id);
            return redirect()->route('trainings.index')->with('success', 'Inscrição cancelada com sucesso. Você não será cobrado.');
        } else {
            $training->users()->updateExistingPivot($user->id, ['presence' => false]);
            return redirect()->route('trainings.index')->with('success', 'Inscrição cancelada com sucesso. A presença será marcada como ausente e você será cobrado.');
        }
    }


}
