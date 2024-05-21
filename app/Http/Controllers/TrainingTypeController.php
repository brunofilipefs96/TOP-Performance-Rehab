<?php

namespace App\Http\Controllers;

use App\Models\TrainingType;
use App\Http\Requests\StoreTrainingTypeRequest;
use App\Http\Requests\UpdateTrainingTypeRequest;

class TrainingTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $training_types = TrainingType::orderBy('id', 'desc')->paginate(15);
        return view('pages.training_types.index', ['training_types' => $training_types]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.training_types.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTrainingTypeRequest $request)
    {
        $validatedData = $request->validated();
        TrainingType::create($validatedData);
        return redirect()->route('training_types.index')->with('success', 'Training type created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(TrainingType $trainingType)
    {
        return view('pages.training_types.show', ['training_type' => $trainingType]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TrainingType $trainingType)
    {
        return view('pages.training_types.edit', ['training_type' => $trainingType]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTrainingTypeRequest $request, TrainingType $trainingType)
    {
        $validatedData = $request->validated();
        $trainingType->update($validatedData);
        return redirect()->route('training_types.index')->with('success', 'Training type updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TrainingType $trainingType)
    {
        $trainingType->delete();
        return redirect()->route('training_types.index')->with('success', 'Training type deleted successfully.');
    }
}
