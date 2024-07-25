<?php

namespace App\Http\Controllers;

use App\Models\Pack;
use App\Http\Requests\StorePackRequest;
use App\Http\Requests\UpdatePackRequest;
use App\Models\TrainingType;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PackController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Pack::class);

        $filter = $request->input('filter', 'all');

        $query = Pack::query()
            ->join('training_types', 'packs.training_type_id', '=', 'training_types.id')
            ->select('packs.*', 'training_types.has_personal_trainer', 'training_types.max_capacity');

        if ($filter == 'personal_trainer') {
            $query->where('training_types.has_personal_trainer', true);
        } elseif ($filter == 'individual') {
            $query->where('training_types.has_personal_trainer', false);
        }

        $packs = $query->orderBy('training_types.has_personal_trainer', 'asc')
            ->orderBy('training_types.max_capacity', 'asc')
            ->orderBy('packs.price', 'asc')
            ->paginate(12);

        $showMembershipModal = false;
        if (auth()->user()->hasRole('client') && (!auth()->user()->membership || auth()->user()->membership->status->name !== 'active') && !session()->has('packs_membership_modal_shown')) {
            session(['packs_membership_modal_shown' => true]);
            $showMembershipModal = true;
        }

        return view('pages.packs.index', [
            'packs' => $packs,
            'showMembershipModal' => $showMembershipModal,
            'filter' => $filter
        ]);
    }




    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Pack::class);
        $training_types = TrainingType::all();

        if ($training_types->isEmpty()) {
            return redirect()->route('packs.index')->with('error', 'Por favor, crie pelo menos um tipo de treino antes de criar um pack.');
        }

        return view('pages.packs.create', ['training_types' => $training_types]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePackRequest $request)
    {
        $validatedData = $request->validated();
        Pack::create($validatedData);
        return redirect()->route('packs.index')->with('success', 'Pack criado com sucesso.');
    }


    /**
     * Display the specified resource.
     */
    public function show(Pack $pack)
    {
        $this->authorize('view', $pack);

        $showMembershipModal = false;

        if (auth()->user()->hasRole('client') && (!auth()->user()->membership || auth()->user()->membership->status->name !== 'active') && !session()->has('membership_modal_shown')) {
            session(['membership_modal_shown' => true]);
            $showMembershipModal = true;
        }

        return view('pages.packs.show', ['pack' => $pack, 'showMembershipModal' => $showMembershipModal]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pack $pack)
    {
        $this->authorize('update', $pack);
        $training_types = TrainingType::all();
        return view('pages.packs.edit', ['pack' => $pack, 'training_types' => $training_types]);
    }

    public function update(UpdatePackRequest $request, Pack $pack)
    {
        $validatedData = $request->validated();
        $pack->update($validatedData);
        return redirect()->route('packs.index')->with('success', 'Pack atualizado com sucesso.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pack $pack)
    {
        $this->authorize('delete', $pack);

        if($pack->memberships()){
            $pack->memberships()->detach();
        }

        $pack->delete();

        return redirect()->route('packs.index')->with('success', 'Pack deleted successfully.');
    }
}
