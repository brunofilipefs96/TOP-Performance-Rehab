<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Training;
use App\Http\Requests\StoreTrainingRequest;
use App\Http\Requests\UpdateTrainingRequest;
use App\Models\TrainingType;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class TrainingController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Training::class);
        $trainings = Training::orderBy('id', 'desc')->paginate(10);
        return view('pages.trainings.index', ['trainings' => $trainings]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Training::class);
        $rooms = Room::all();
        $trainingTypes = TrainingType::all();

        return view('pages.trainings.create', ['rooms' => $rooms, 'trainingTypes' => $trainingTypes]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTrainingRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData['personal_trainer_id'] = auth()->user()->id;

        Training::create($validatedData);
        return redirect()->route('trainings.index')->with('success', 'Training created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Training $training)
    {
        $this->authorize('view', $training);
        return view('pages.trainings.show', ['training' => $training]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Training $training)
    {
        $this->authorize('update', $training);
        return view('pages.trainings.edit', ['training' => $training]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTrainingRequest $request, Training $training)
    {
        $validatedData = $request->validated();

        $training->update($validatedData);

        return redirect()->route('trainings.index')->with('success', 'Training updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
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
