<?php

namespace App\Http\Controllers;

use App\Models\Insurance;
use App\Models\Membership;
use App\Http\Requests\StoreMembershipRequest;
use App\Http\Requests\UpdateMembershipRequest;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Redirect;
use MattDaneshvar\Survey\Models\Entry;
use MattDaneshvar\Survey\Models\Survey;

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

        $addresses = auth()->user()->addresses;

        return view('pages.memberships.create', ['addresses' => $addresses]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMembershipRequest $request)
    {
        $membership = Membership::create([
            'user_id' => auth()->id(),
            'address_id' => $request->address_id,
        ]);

        //return redirect()->route('memberships.show', ['membership' => $membership])->with('success', 'Membership Created!');
        return redirect()->route('setup.trainingTypesShow')->with('success', 'Membership Created!');

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

        $status = Status::where('name', $request->input('status_name'))->firstOrFail();

        $membership->status_id = $status->id;

        if($membership->status->name == 'active') {
            $membership->start_date = now();
            $membership->end_date = now()->addMonth();
        }

        $membership->save();

        return redirect()->route('memberships.show', ['membership' => $membership])->with('success', 'Membership Updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Membership $membership)
    {
        $this->authorize('delete', $membership);
        $membership->delete();
        return redirect()->route('memberships.index')->with('success', 'Membership Deleted!');
    }

    public function form(Request $request)
    {
        $this->authorize('form', Membership::class);

        $entries = Entry::find($request->entry)->questions;

        return view('pages.memberships.form', ['entries' => $entries]);
    }

}
