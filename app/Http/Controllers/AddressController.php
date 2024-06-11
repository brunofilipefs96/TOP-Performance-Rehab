<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Http\Requests\StoreAddressRequest;
use App\Http\Requests\UpdateAddressRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Redirect;

class AddressController extends Controller
{
    use AuthorizesRequests;

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAddressRequest $request)
    {
        $validatedData = $request->validated();

        Address::create($validatedData + ['user_id' => auth()->id()]);

        return Redirect::back()->with('status', 'Address Created!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAddressRequest $request, Address $address)
    {
        $this->authorize('update', $address);

        $validatedData = $request->validated();

        $address->update($validatedData);

        return Redirect::back()->with('status', 'Address Updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Address $address)
    {
        $this->authorize('delete', $address);

        if ($address->user->membership->exists()) {
            return Redirect::back()->with('status', 'A morada está associado a um Matrícula!');
        }

        $address->delete();

        return Redirect::back()->with('status', 'Address Deleted!');
    }
}
