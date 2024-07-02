<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\TrainingType;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SetupController extends Controller
{
    public function setup()
    {
        $user = auth()->user();

        if (!$user->hasRole('client') || (($user->membership && $user->membership->status->name == 'active') && ($user->membership->insurance->status->name == 'active'))) {
            return redirect()->route('dashboard')->with('error', 'Não tem permissão para aceder a esta página.');
        }

        if (!$user->addresses || $user->addresses->count() <= 0) {
            return redirect()->route('setup.addressShow');
        }

        if (!$user->membership) {
            return redirect()->route('setup.membershipShow');
        }

        if ($user->membership->trainingTypes->count() <= 0) {
            return redirect()->route('setup.trainingTypesShow');
        }

        if($user->addresses || $user->addresses->count() <= 0 && $user->membership && $user->membership->trainingTypes->count() <= 0 && $user->insurance) {
            if($user->membership->status->name == 'active' && $user->membership->insurance->status->name) {
                return redirect()->route('setup.paymentShow');
            }
            return redirect()->route('setup.awaitingShow');
        }

        if (!$user->insurance) {
            return redirect()->route('setup.insuranceShow');
        }

        if ($user->membership->status->name == 'pending_payment' && $user->insurance->status->name == 'pending_payment') {
            return redirect()->route('setup.paymentShow');
        }

        return redirect()->route('dashboard')->with('success', 'Processo de inscrição completo.');
    }

    public function addressShow()
    {
        $user = auth()->user();

        if (!$user->hasRole('client') || (($user->membership && $user->membership->status->name == 'active') && ($user->membership->insurance->status->name == 'active'))) {
            return redirect()->route('dashboard')->with('error', 'Não tem permissão para aceder a esta página.');
        }

        return view('pages.setup.addressShow', ['user' => $user]);
    }

    public function membershipShow()
    {
        $user = auth()->user();

        if (!$user->hasRole('client') || (($user->membership && $user->membership->status->name == 'active') && ($user->membership->insurance->status->name == 'active'))) {
            return redirect()->route('dashboard')->with('error', 'Não tem permissão para aceder a esta página.');
        }

        if(!$user->addresses || $user->addresses->count() <= 0){
            return redirect()->route('setup.addressShow');
        }

        return view('pages.setup.membershipShow', ['user' => $user]);
    }

    public function trainingTypesShow()
    {
        $user = auth()->user();

        if (!$user->hasRole('client') || (($user->membership && $user->membership->status->name == 'active') && ($user->membership->insurance->status->name == 'active'))) {
            return redirect()->route('dashboard')->with('error', 'Não tem permissão para aceder a esta página.');
        }

        if(!$user->addresses || $user->addresses->count() <= 0){
            return redirect()->route('setup.addressShow');
        } else if (!$user->membership) {
            return redirect()->route('setup.membershipShow');
        }

        $trainingTypes = TrainingType::all();
        $userTrainingTypes = $user->membership->trainingTypes->pluck('id')->toArray() ?? [];

        return view('pages.setup.trainingTypesShow', ['user' => $user, 'trainingTypes' => $trainingTypes, 'userTrainingTypes' => $userTrainingTypes]);
    }


    public function insuranceShow()
    {
        $user = auth()->user();

        if (!$user->hasRole('client') || (($user->membership && $user->membership->status->name == 'active') && ($user->membership->insurance->status->name == 'active'))) {
            return redirect()->route('dashboard')->with('error', 'Não tem permissão para aceder a esta página.');
        }

        if(!$user->addresses || $user->addresses->count() <= 0){
            return redirect()->route('setup.addressShow');
        } else if (!$user->membership) {
            return redirect()->route('setup.membershipShow');
        } else if(!$user->membership->trainingTypes) {
            return redirect()->route('setup.trainingTypesShow');
        }

        return view('pages.setup.insuranceShow', ['user' => $user]);
    }

    public function awaitingShow()
    {
        $user = auth()->user();

        if (!$user->hasRole('client') || (($user->membership && $user->membership->status->name == 'active') && ($user->membership->insurance->status->name == 'active'))) {
            return redirect()->route('dashboard')->with('error', 'Não tem permissão para aceder a esta página.');
        }

        if(!$user->addresses || $user->addresses->count() <= 0){
            return redirect()->route('setup.addressShow');
        } else if (!$user->membership) {
            return redirect()->route('setup.membershipShow');
        } else if(!$user->membership->trainingTypes) {
            return redirect()->route('setup.trainingTypesShow');
        } else if(!$user->membership->insurance){
            return redirect()->route('setup.insuranceShow');
        } else if (($user->membership && $user->membership->status->name == 'pending_payment') && ($user->membership->insurance->status->name == 'pending_payment')){
            return redirect()->route('setup.paymentShow');
        }

        return view('pages.setup.awaitingShow', ['user' => $user]);
    }

    public function paymentShow()
    {
        $user = auth()->user();

        if (!$user->hasRole('client') || ($user->membership && $user->membership->status->name == 'active')) {
            return redirect()->route('dashboard')->with('error', 'Não tem permissão para aceder a esta página.');
        }

        if ($user->membership->status->name != 'pending_payment' && $user->insurance->status->name != 'pending_payment') {
            return redirect()->route('setup');
        }

        if (!$user->hasRole('client') || ($user->membership && $user->membership->status->name == 'active')) {
            return redirect()->route('dashboard')->with('error', 'Não tem permissão para aceder a esta página.');
        }

        if(!$user->addresses || $user->addresses->count() <= 0){
            return redirect()->route('setup.addressShow');
        } else if (!$user->membership) {
            return redirect()->route('setup.membershipShow');
        } else if(!$user->membership->trainingTypes) {
            return redirect()->route('setup.trainingTypesShow');
        } else if(!$user->membership->insurance){
            return redirect()->route('setup.insuranceShow');
        }


        return view('pages.setup.paymentShow',  ['user' => $user]);
    }

    public function storeAddress(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'new_address' => 'nullable|in:on',
        ]);

        if ($request->input('new_address') === 'on') {
            $validator->after(function ($validator) use ($request) {
                $additionalRules = [
                    'name' => 'required|string|max:255',
                    'street' => 'required|string|max:255',
                    'city' => 'required|string|max:255',
                    'postal_code' => [
                        'required',
                        'string',
                        'max:8',
                        function ($attribute, $value, $fail) {
                            if (!preg_match('/^\d{4}-\d{3}$/', $value)) {
                                $fail('O campo ' . $attribute . ' deve estar no formato xxxx-xxx.');
                            }
                        },
                    ],
                ];

                $additionalValidator = Validator::make($request->all(), $additionalRules);

                if ($additionalValidator->fails()) {
                    foreach ($additionalValidator->errors()->messages() as $field => $messages) {
                        foreach ($messages as $message) {
                            $validator->errors()->add($field, $message);
                        }
                    }
                }
            });
        } else {
            $validator->addRules([
                'address_id' => 'required|exists:addresses,id',
            ]);
        }

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if ($request->input('new_address') === 'on') {
            $address = new Address();
            $address->name = $request->input('name');
            $address->street = $request->input('street');
            $address->city = $request->input('city');
            $address->postal_code = $request->input('postal_code');
            $address->user_id = auth()->id();
            $address->save();
        }

        return redirect()->route('setup.membershipShow');
    }
    public function storeTrainingTypes(Request $request)
    {
        $user = auth()->user();

        if (!$user->membership) {
            return redirect()->route('setup.membershipShow')->with('error', 'Você precisa primeiro criar uma matrícula.');
        }

        $trainingTypeIds = $request->input('trainingTypes', []);

        $user->membership->trainingTypes()->sync($trainingTypeIds);

        return redirect()->route('setup.insuranceShow')->with('success', 'Modalidades selecionadas com sucesso.');
    }


}
