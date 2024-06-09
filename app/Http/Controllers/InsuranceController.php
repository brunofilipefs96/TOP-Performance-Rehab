<?php

namespace App\Http\Controllers;

use App\Models\Insurance;
use App\Http\Requests\StoreInsuranceRequest;
use App\Http\Requests\UpdateInsuranceRequest;
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
        $insurance->update($request->validated());
        return redirect()->route('insurances.show', ['insurance' => $insurance]);
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

    public function updateStatus(Request $request, Insurance $insurance, $status)
    {
        if (!in_array($status, ['active', 'inactive'])) {
            return redirect()->back()->withErrors('Status inválido.');
        }

        // Atualiza o status do seguro
        $insurance->status = $status;
        $insurance->save();

        return redirect()->route('insurances.index')->with('success', 'Estado atualizado com sucesso!');
    }
}
