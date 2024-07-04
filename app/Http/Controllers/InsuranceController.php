<?php

namespace App\Http\Controllers;

use App\Models\Insurance;
use App\Http\Requests\StoreInsuranceRequest;
use App\Http\Requests\UpdateInsuranceRequest;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Redirect;

class InsuranceController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Insurance::class);
        $insurances = Insurance::orderBy('id', 'desc')->paginate(12);
        return view('pages.insurances.index', ['insurances' => $insurances]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $this->authorize('create', Insurance::class);
        return view('pages.insurances.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInsuranceRequest $request)
    {
        $insurance = Insurance::create([
            'membership_id' => auth()->user()->membership->id,
            'status_id' => Status::where('name', 'pending')->firstOrFail()->id,
            'insurance_type' => $request->insurance_type,
            'start_date' => $request->start_date ?? now(),
            'end_date' => $request->end_date ?? now()->addYear(),
        ]);

        //return view('pages.insurances.show', ['insurance' => $insurance] )->with('success', 'Insurance Created!');
        return redirect()->route('setup.awaitingShow')->with('success', 'Insurance Created!');
    }


    /**
     * Display the specified resource.
     */
    public function show(Insurance $insurance)
    {
        $this->authorize('view', $insurance);
        return view('pages.insurances.show', ['insurance' => $insurance]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Insurance $insurance)
    {
        $this->authorize('update', $insurance);
        return view('pages.insurances.edit', ['insurance' => $insurance]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInsuranceRequest $request, Insurance $insurance)
    {
        $this->authorize('update', $insurance);

        $status = Status::where('name', $request->input('status_name'))->firstOrFail();

        $insurance->status_id = $status->id;

        if($insurance->status->name == 'active') {
            $insurance->start_date = now();
            $insurance->end_date = now()->addYear();
        }

        $insurance->save();

        return redirect()->route('insurances.show', ['insurance' => $insurance])->with('success', 'Insurance Updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Insurance $insurance)
    {
        $this->authorize('delete', $insurance);

        $insurance->delete();

        return Redirect::back()->with('success', 'Insurance Deleted!');
    }
}
