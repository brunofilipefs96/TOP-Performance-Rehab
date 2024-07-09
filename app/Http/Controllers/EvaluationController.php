<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use App\Http\Requests\StoreEvaluationRequest;
use App\Http\Requests\UpdateEvaluationRequest;
use App\Models\Membership;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class EvaluationController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function create(Membership $membership)
    {
        $this->authorize('create', Evaluation::class);
        return view('pages.evaluations.create', ['membership' => $membership]);
    }

    public function store(StoreEvaluationRequest $request, Membership $membership)
    {
        $this->authorize('create', Evaluation::class);

        $validatedData = $request->validated();

        $evaluation = new Evaluation($validatedData);
        $evaluation->save();

        $membership->evaluations()->attach($evaluation->id);

        return redirect()->route('memberships.evaluations.list', ['membership' => $membership->id])
            ->with('success', 'Avaliação adicionada com sucesso!');
    }

    public function show(Membership $membership, Evaluation $evaluation)
    {
        $this->authorize('view', $evaluation);
        return view('pages.evaluations.show', ['evaluation' => $evaluation, 'membership' => $membership]);
    }


    public function destroy(Membership $membership, Evaluation $evaluation)
    {
        $this->authorize('delete', $evaluation);
        $evaluation->delete();
        return redirect()->route('memberships.evaluations.list', ['membership' => $evaluation->membership_id])->with('success', 'Avaliação eliminada com sucesso!');

    }

    public function listForMembership(Membership $membership)
    {
        $this->authorize('viewAny', Evaluation::class);

        if($membership->status->name == 'active') {
            $evaluations = $membership->evaluations()->orderBy('created_at', 'desc')->paginate(12);
            return view('pages.evaluations.list', ['evaluations' => $evaluations, 'membership' => $membership]);
        }
        return redirect('memberships/'.$membership->id);
    }
}
