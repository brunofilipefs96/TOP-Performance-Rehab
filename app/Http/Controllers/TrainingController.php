<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Training;
use App\Http\Requests\StoreTrainingRequest;
use App\Http\Requests\UpdateTrainingRequest;
use App\Models\TrainingType;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class TrainingController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('viewAny', Training::class);
        $trainings = Training::orderBy('id', 'desc')->paginate(10);
        return view('pages.trainings.index', ['trainings' => $trainings]);
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
        Training::create($validatedData);
        return redirect()->route('trainings.index')->with('success', 'Training created successfully.');
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
        $training->update($validatedData);
        return redirect()->route('trainings.index')->with('success', 'Training updated successfully.');
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
        if ($training->users()->count() < $training->max_students) {
            $training->users()->attach($user->id, ['presence' => false]);
            return redirect()->route('trainings.show', $training)->with('success', 'Enrolled successfully.');
        } else {
            return redirect()->route('trainings.show', $training)->with('error', 'Training is full.');
        }
    }

}
