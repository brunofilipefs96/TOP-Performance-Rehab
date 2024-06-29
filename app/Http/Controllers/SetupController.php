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

        if (!$user->hasRole('client') || ($user->membership && $user->membership->status->name == 'active')) {
            return redirect()->route('dashboard.index')->with('error', 'Não tem permissão para aceder a esta página.');
        }

        // Verifica se o usuário não tem endereço cadastrado
        if (!$user->addresses || $user->addresses->count() <= 0) {
            return redirect()->route('setup.addressShow');
        }

        // Verifica se o usuário não tem uma associação ou se a associação não está ativa
        if (!$user->membership) {
            return redirect()->route('setup.membershipShow');
        }

        // Verifica se o usuário não tem tipos de treinamento selecionados
        if ($user->membership->trainingTypes->count() <= 0) {
            return redirect()->route('setup.trainingTypesShow');
        }

        // Verifica se o usuário não tem seguro ou se o seguro não está ativo
        if (!$user->insurance) {
            return redirect()->route('setup.insuranceShow');
        }

        // Verifica se o pagamento não foi realizado
        if ($user->membership->status->name == 'pending_payment' && $user->insurance->status->name == 'pending_payment') {
            return redirect()->route('setup.paymentShow');
        }

        // Se todos os passos estão completos, redireciona para o dashboard
        return redirect()->route('dashboard.index')->with('success', 'Processo de inscrição completo.');
    }

    public function addressShow()
    {
        $user = auth()->user();

        if (!$user->hasRole('client') || ($user->membership && $user->membership->status->name == 'active')) {
            return redirect()->route('dashboard.index')->with('error', 'Não tem permissão para aceder a esta página.');
        }

        return view('pages.setup.addressShow', ['user' => $user]);
    }

    public function membershipShow()
    {
        $user = auth()->user();

        if (!$user->hasRole('client') || ($user->membership && $user->membership->status->name == 'active')) {
            return redirect()->route('dashboard.index')->with('error', 'Não tem permissão para aceder a esta página.');
        }

        return view('pages.setup.membershipShow', ['user' => $user]);
    }

    public function trainingTypesShow()
    {
        $user = auth()->user();

        if (!$user->hasRole('client') || ($user->membership && $user->membership->status->name == 'active')) {
            return redirect()->route('dashboard.index')->with('error', 'Não tem permissão para aceder a esta página.');
        }

        // Verifica se o usuário já tem uma associação
        if (!$user->membership) {
            return redirect()->route('setup.membershipShow');
        }

        $trainingTypes = TrainingType::all();

        return view('pages.setup.trainingTypesShow', ['user' => $user, 'trainingTypes' => $trainingTypes]);
    }

    public function insuranceShow()
    {
        $user = auth()->user();

        if (!$user->hasRole('client') || ($user->membership && $user->membership->status->name == 'active')) {
            return redirect()->route('dashboard.index')->with('error', 'Não tem permissão para aceder a esta página.');
        }

        // Verifica se o usuário já tem uma associação
        if (!$user->membership) {
            return redirect()->route('setup.membershipShow');
        }

        return view('pages.setup.insuranceShow', ['user' => $user]);
    }

    public function paymentShow()
    {
        $user = auth()->user();

        if (!$user->hasRole('client') || ($user->membership && $user->membership->status->name == 'active')) {
            return redirect()->route('dashboard.index')->with('error', 'Não tem permissão para aceder a esta página.');
        }

        // Verifica se o pagamento não foi realizado
        if ($user->membership->status->name != 'pending_payment' || $user->insurance->status->name != 'pending_payment') {
            return redirect()->route('setup');
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
}
