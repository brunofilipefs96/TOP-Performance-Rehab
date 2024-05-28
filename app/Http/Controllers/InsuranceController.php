<?php

namespace App\Http\Controllers;

use App\Models\Insurance;
use App\Http\Requests\StoreInsuranceRequest;
use App\Http\Requests\UpdateInsuranceRequest;
use http\Env\Request;
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
        //
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInsuranceRequest $request)
    {
        $validatedData = $request->validated();

        $insurance = new Insurance($validatedData);

        $insurance->membership_id = auth()->user()->membership->id;

        $insurance->save();

        return Redirect::back()->with('status', 'Insurance Created!');
    }


    /**
     * Display the specified resource.
     */
    public function show(Insurance $insurance)
    {
        //
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

        $validatedData = $request->validated();

        $insurance->update($validatedData);

        return Redirect::back()->with('status', 'Insurance Updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Insurance $insurance)
    {
        $this->authorize('delete', $insurance);

        $insurance->delete();

        return Redirect::back()->with('status', 'Insurance Deleted!');
    }
}
