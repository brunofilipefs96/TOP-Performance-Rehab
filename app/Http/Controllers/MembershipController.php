<?php

namespace App\Http\Controllers;

use App\Models\Insurance;
use App\Models\Membership;
use App\Http\Requests\StoreMembershipRequest;
use App\Http\Requests\UpdateMembershipRequest;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Redirect;
use MattDaneshvar\Survey\Models\Entry;

class MembershipController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Membership::class);
        $memberships = Membership::orderBy('id', 'desc')->paginate(12);
        return view('pages.memberships.index', ['memberships' => $memberships]);
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

        $membership = Membership::create([
            'user_id' => auth()->id(),
            'address_id' => $request->address_id,
            'monthly_plan' => $request->monthly_plan,
        ]);

        return redirect()->route('memberships.show', ['membership' => $membership]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Membership $membership)
    {
        $this->authorize('view', $membership);
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
        $this->authorize('update', $membership);
        $membership->update($request->validated());
        return redirect()->route('memberships.show', ['membership' => $membership]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Membership $membership)
    {
        $this->authorize('delete', $membership);
        $membership->delete();
        return redirect()->route('memberships.index')->with('success', 'Product deleted successfully.');
    }

    public function form(Request $request)
    {
        $this->authorize('form', Membership::class);

        $entries = Entry::find($request->entry)->questions;

        return view('pages.memberships.form', ['entries' => $entries]);
    }

    public function updateStatus(Request $request, Membership $membership, $status)
    {
        $membership->status = $status;
        $membership->save();

        return redirect()->route('memberships.index', ['membership' => $membership])->with('success', 'Status atualizado com sucesso!');
    }
}
