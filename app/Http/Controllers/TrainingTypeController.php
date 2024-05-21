<?php

namespace App\Http\Controllers;

use App\Models\TrainingType;
use App\Http\Requests\StoreTrainingTypeRequest;
use App\Http\Requests\UpdateTrainingTypeRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TrainingTypeController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', TrainingType::class);
        $trainingTypes = TrainingType::orderBy('id', 'desc')->paginate(10);
        return view('pages.training_types.index', ['training_types' => $trainingTypes]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', TrainingType::class);
        return view('pages.training_types.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTrainingTypeRequest $request)
    {
        $validatedData = $request->validated();

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('training_types', 'public');
            $validatedData['image'] = $path;
        }

        TrainingType::create($validatedData);

        return redirect()->route('training_types.index')->with('success', 'Training type created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(TrainingType $trainingType)
    {
        $this->authorize('view', $trainingType);
        return view('pages.training_types.show', ['training_type' => $trainingType]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TrainingType $trainingType)
    {
        $this->authorize('update', $trainingType);
        return view('pages.training_types.edit', ['training_type' => $trainingType]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTrainingTypeRequest $request, TrainingType $trainingType)
    {
        $validatedData = $request->validated();

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('training_types', 'public');
            $validatedData['image'] = $path;
        }

        $trainingType->update($validatedData);

        return redirect()->route('training_types.index')->with('success', 'Training type updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TrainingType $trainingType)
    {
        $this->authorize('delete', $trainingType);
        $trainingType->delete();
        return redirect()->route('training_types.index')->with('success', 'Training type deleted successfully.');
    }
}
