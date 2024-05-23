<?php

namespace App\Http\Controllers;

use App\Models\Membership;
use App\Http\Requests\StoreMembershipRequest;
use App\Http\Requests\UpdateMembershipRequest;
use App\Models\Question;
use App\Models\Questionnaire;
use App\Models\Response;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class MembershipController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $this->authorize('create', Membership::class);
        return view ('pages.memberships.create');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMembershipRequest $request)
    {
        $this->authorize('create', Membership::class);
        $validatedData = $request->validated();
        Membership::create($validatedData);
        return redirect()->route('users.index')->with('success', 'Membership created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Membership $membership)
    {
        $this->authorize('view', Membership::class);
        return view('pages.memberships.show', ['membership' => $membership]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Membership $membership)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMembershipRequest $request, Membership $membership)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Membership $membership)
    {
        //
    }

    public function form(Request $request)
    {
        $this->authorize('form', Membership::class);

        $questionnaire = Questionnaire::findOrFail(request('questionnaire'));

        return view('pages.memberships.form', ['questionnaire' => $questionnaire]);
    }


    public function storeForm(Request $request, Membership $membership)
    {
        $this->authorize('form', Membership::class);

        $validatedData = $request->validate([
            'responses' => 'required|array',
            'responses.*.question_id' => 'required|exists:questions,id',
            'responses.*.response_text' => 'required',
        ]);

        foreach ($validatedData['responses'] as $reponse) {
            $question = Question::findOrFail($reponse['question_id']);

            if (!$membership->questionnaires->contains($question->questionnaire_id)) {
                return redirect()->back()->with('error', 'A pergunta não pertence ao questionário associado.');
            }

            $response2 = new Response([
                'response' => $reponse['response'],
                'user_id' => auth()->id(),
            ]);

            $question->responses()->save($response2);
        }

        return redirect()->route('users.index')->with('success', 'Formulário enviado com sucesso.');
    }

}
