<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Sale;
use App\Models\Setting;
use App\Models\TrainingType;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Stripe\PaymentIntent;
use Stripe\PaymentMethod;
use Stripe\Stripe;
use Stripe\StripeClient;

class SetupController extends Controller
{
    public function setup()
    {
        $user = auth()->user();

        foreach ($user->sales as $sale) {
            if ($sale->products()->count() == 0 && $sale->packs()->count() == 0) {
                if ($user->membership->status->name == 'pending_payment') {
                    return redirect('sales/'.$sale->id);
                } else {
                    return redirect('memberships/'.$user->membership->id);
                }
            }
        }

        if($user->membership){
            if ($user->membership->status->name == 'inactive' || $user->membership->insurance->status->name == 'inactive') {
                return redirect()->route('renew');
            }
        }

        if(($user->membership && $user->membership->status->name == 'active') || ($user->membership && $user->membership->status->name == 'frozen')){
            return redirect('memberships/'. $user->membership->id);
        }

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
            return redirect()->route('setup.awaitingShow');
        }

        if ($user->membership->status->name == 'pending_payment' && $user->insurance->status->name == 'active') {
            return redirect()->route('setup.awaitingShow');
        }

        if($user->membership->status->name == 'rejected' || $user->membership->insurance->status->name == 'rejected') {
            return redirect()->route('awaitingShow');
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

        if (!$user->hasRole('client') || (($user->membership && $user->membership->status->name == 'active') && ($user->membership->insurance->status->name == 'active'))) {
            return redirect()->route('dashboard')->with('error', 'Não tem permissão para aceder a esta página.');
        }

        if ($user->membership && $user->membership->status->name != 'pending_payment' && $user->insurance && $user->insurance->status->name != 'pending_payment') {
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
    public function renewShow() {

        $user = auth()->user();

        if ($user->membership->status->name != 'inactive' || $user->membership->insurance->name == 'inactive') {
            return redirect()->route('dashboard')->with('error', 'Apenas memberships inativas podem ser renovadas.');
        }

        return view('pages.setup.renewShow', ['user' => $user]);
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

    public function updateTrainingTypes(Request $request)
    {
        $user = auth()->user();

        if (!$user->membership) {
            return redirect()->route('setup.membershipShow')->with('error', 'Você precisa primeiro criar uma matrícula.');
        }

        $trainingTypeIds = $request->input('trainingTypes', []);

        $currentTrainingTypes = $user->membership->trainingTypes->pluck('id')->toArray();
        if ($currentTrainingTypes != $trainingTypeIds) {
            $user->membership->trainingTypes()->sync($trainingTypeIds);
            return redirect()->route('setup.insuranceShow')->with('success', 'Modalidades atualizadas com sucesso.');
        }

        return redirect()->route('setup.insuranceShow');
    }

    public function processSetup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nif_option' => 'required|in:personal,final',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = auth()->user();
        $membership = $user->membership;
        $addressId = $membership->address_id;

        if (!$addressId) {
            return redirect()->back()->withErrors(['address' => 'Endereço não encontrado para esta associação.'])->withInput();
        }

        $nif = $request->input('nif_option') === 'personal' ? $user->nif : '999999990';

        $total = setting('taxa_inscricao');
        if ($membership->insurance->insurance_type == 'Ginásio') {
            $total += setting('taxa_seguro');
        }

        Stripe::setApiKey(env('STRIPE_SECRET'));
        $stripe = new StripeClient(env('STRIPE_SECRET'));

        try {
            $paymentMethod = $stripe->paymentMethods->create([
                'type' => 'multibanco',
                'billing_details' => [
                    'email' => $user->email,
                ],
            ]);

            $paymentIntent = $stripe->paymentIntents->create([
                'amount' => $total * 100,
                'currency' => 'eur',
                'payment_method_types' => ['multibanco'],
                'payment_method' => $paymentMethod->id,
                'confirmation_method' => 'automatic',
                'confirm' => true,
            ]);

            $existingSale = Sale::where('user_id', $user->id)
                ->where('created_at', '>=', Carbon::now()->subMinutes(1))
                ->first();

            if ($existingSale) {
                return redirect()->back()->with('error', 'Você já processou um pagamento recentemente. Por favor, aguarde um momento.');
            }

            $sale = Sale::create([
                'user_id' => $user->id,
                'address_id' => $addressId,
                'status_id' => 5,
                'total' => $total,
                'payment_method' => 'multibanco',
                'nif' => $nif,
            ]);

            $sale->payment_intent_id = $paymentIntent->id;
            $sale->save();

            return redirect()->route('sales.show', ['sale' => $sale->id]);

        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Ocorreu um erro ao processar o pagamento: ' . $e->getMessage()])->withInput();
        }
    }
}
