<?php

namespace App\Http\Controllers;

use App\Models\Questionnaire;
use App\Http\Requests\StoreQuestionnaireRequest;
use App\Http\Requests\UpdateQuestionnaireRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class QuestionnaireController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Questionnaire::class);

        $questionnaires = Questionnaire::orderBy('id', 'desc')->paginate(10);

        return view('pages.questionnaires.index', ['questionnaires' => $questionnaires]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Questionnaire::class);

        return view('pages.questionnaires.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreQuestionnaireRequest $request)
    {
        $validatedData = $request->validated();

        Questionnaire::create($validatedData);

        return redirect()->route('questionnaires.index')->with('success', 'Questionnaire created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Questionnaire $questionnaire)
    {
        $this->authorize('view', $questionnaire);

        return view('pages.questionnaires.show', ['questionnaire' => $questionnaire]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Questionnaire $questionnaire)
    {
        $this->authorize('update', $questionnaire);
        return view('pages.questionnaires.edit', ['questionnaire' => $questionnaire]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateQuestionnaireRequest $request, Questionnaire $questionnaire)
    {
        $validatedData = $request->validated();

        $questionnaire->update($validatedData);

        return redirect()->route('questionnaires.index')->with('success', 'Questionnaire updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Questionnaire $questionnaire)
    {
        $this->authorize('delete', $questionnaire);
        $questionnaire->delete();
        return redirect()->route('questionnaires.index')->with('success', 'Questionnaire deleted successfully.');
    }
}
