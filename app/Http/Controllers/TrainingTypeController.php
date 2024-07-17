<?php

namespace App\Http\Controllers;

use App\Models\TrainingType;
use App\Http\Requests\StoreTrainingTypeRequest;
use App\Http\Requests\UpdateTrainingTypeRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Storage;

class TrainingTypeController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', TrainingType::class);
        $trainingTypes = TrainingType::orderBy('id', 'desc')->paginate(12);
        return view('pages.training-types.index', ['training_types' => $trainingTypes]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', TrainingType::class);
        return view('pages.training-types.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTrainingTypeRequest $request)
    {
        $validatedData = $request->validated();

        if (!$request->has_personal_trainer) {
            $validatedData['max_capacity'] = null;
        }

        $trainingType = new TrainingType($validatedData);
        $trainingType->save();

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image');
            $imageName = $trainingType->id . '_' . time() . '_' . $imagePath->getClientOriginalName();
            $path = $request->file('image')->storeAs('images/training_types/' . $trainingType->id, $imageName, 'public');
            $validatedData['image'] = $path;
            $trainingType->image = $path;
        }

        $trainingType->save();

        return redirect()->route('training-types.index')->with('success', 'Training type created successfully.');
    }


    /**
     * Display the specified resource.
     */
    public function show(TrainingType $trainingType)
    {
        $this->authorize('view', $trainingType);
        return view('pages.training-types.show', ['training_type' => $trainingType]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TrainingType $trainingType)
    {
        $this->authorize('update', $trainingType);
        return view('pages.training-types.edit', ['training_type' => $trainingType]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTrainingTypeRequest $request, TrainingType $trainingType)
    {
        $validatedData = $request->validated();

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image');
            $imageName = $trainingType->id . '_' . time() . '_' . $imagePath->getClientOriginalName();
            $path = $request->file('image')->storeAs('images/training_types/' . $trainingType->id, $imageName, 'public');
            Storage::delete('public/' . $trainingType->image);
            $validatedData['image'] = $path;
        }

        if (!$request->has_personal_trainer) {
            $validatedData['max_capacity'] = null;
        }

        $trainingType->update($validatedData);

        return redirect()->route('training-types.index')->with('success', 'Training type updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TrainingType $trainingType)
    {
        $this->authorize('delete', $trainingType);
        Storage::deleteDirectory('public/images/training_types/' . $trainingType->id);
        $trainingType->delete();
        return redirect()->route('training-types.index')->with('success', 'Training type deleted successfully.');
    }
}
