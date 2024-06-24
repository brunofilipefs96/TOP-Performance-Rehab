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

        if ($address->user->membership && $address->id == $address->user->membership->address_id) {
            return Redirect::back()->with('status', 'A morada está associada a uma Matrícula!');
        }

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

            if ($address->user->membership && $address->id == $address->user->membership->address_id) {
                return Redirect::back()->with('status', 'A morada está associada a uma Matrícula!');
            }

        $address->delete();

        return Redirect::back()->with('status', 'Morada removida com sucesso!');
    }


}
