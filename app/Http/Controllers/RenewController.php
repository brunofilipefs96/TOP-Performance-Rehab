<?php

namespace App\Http\Controllers;

use App\Models\Insurance;
use App\Models\Sale;
use App\Models\Status;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Stripe\Stripe;
use Stripe\StripeClient;

class RenewController extends Controller
{
    public function renew()
    {
        $user = auth()->user();

        if($user->hasRole('client')){

            if($user->membership && ($user->membership->status->name == 'inactive')){
                return redirect()->route('renew.renewMembership');
            } else if($user->membership && ($user->membership->insurance->status->name == 'inactive')){
                return redirect()->route('renew.renewInsurance');
            } else if($user->membership && (($user->membership->status->name == 'awaiting_insurance') || ($user->membership->status->name == 'renew_pending')) && (($user->membership->insurance->status->name == 'awaiting_membership') || ($user->membership->insurance->status->name == 'renew_pending'))){
                return redirect()->route('renew.renewAwaiting');
            } else if($user->membership && ($user->membership->insurance->status->name == 'pending_renewPayment') && ($user->membership->insurance->status->name == 'pending_renewPayment')){
                return redirect()->route('renew.renewPayment');
            }

        }

        return redirect()->route('dashboard');
    }

    public function renewMembership()
    {
        $user = auth()->user();

        if (!$user->hasRole('client') || ($user->membership && $user->membership->status->name != 'inactive')) {
            return redirect()->route('dashboard')->with('error', 'Não tem permissão para aceder a esta página.');
        }

        return view('pages.renew.renewMembership', ['user' => $user]);
    }

    public function renewInsurance()
    {
        $user = auth()->user();

        if (!$user->hasRole('client') || ($user->membership && $user->membership->insurance->status->name != 'incative')) {
            return redirect()->route('dashboard')->with('error', 'Não tem permissão para aceder a esta página.');
        }

        return view('pages.renew.renewInsurance', ['user' => $user]);
    }

    public function renewAwaiting()
    {
        $user = auth()->user();

        if (!$user->hasRole('client') || (($user->membership && $user->membership->status->name != 'inactive') && ($user->membership->insurance->status->name != 'incative'))) {
            return redirect()->route('dashboard')->with('error', 'Não tem permissão para aceder a esta página.');
        }

        if($user->membership && (($user->membership->status->name != 'awaiting_insurance') || ($user->membership->status->name != 'renew_pending')) && (($user->membership->insurance->status->name != 'awaiting_membership') || ($user->membership->insurance->status->name != 'renew_pending'))) {
            return redirect()->route('dashboard')->with('error', 'Não tem permissão para aceder a esta página.');
        }

        return view('pages.renew.renewAwaiting', ['user' => $user]);
    }

    public function renewPayment()
    {
        $user = auth()->user();

        if (!$user->hasRole('client') || ($user->membership && $user->membership->status->name == 'active')) {
            return redirect()->route('dashboard')->with('error', 'Não tem permissão para aceder a esta página.');
        }

        if (!$user->hasRole('client') || (($user->membership && $user->membership->status->name != 'inactive') && ($user->membership->insurance->status->name != 'incative'))) {
            return redirect()->route('dashboard')->with('error', 'Não tem permissão para aceder a esta página.');
        }

        if ($user->membership && $user->membership->status->name != 'pending_renewPayment' && $user->insurance && $user->insurance->status->name != 'pending_renewPayment') {
            return redirect()->route('renew');
        }

        return view('pages.renew.renewPayment', ['user' => $user]);
    }

    public function updateMembership(Request $request, $id)
    {
        $user = auth()->user();
        $membership = $user->membership;

        if ($membership->status->name == 'inactive') {
            $membership->status_id = Status::where('name', 'renew_pending')->firstOrFail()->id;
            $membership->start_date = now();
            $membership->end_date = now()->addYear();
            $membership->save();
        }

        return redirect()->route('renew')->with('success', 'Membership renovada com sucesso!');
    }

    public function updateInsurance(Request $request, Insurance $insurance)
    {
        $request->validate([
            'insurance_type' => 'required|string|in:Ginásio,Pessoal',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        $insurance->insurance_type = $request->insurance_type;
        $insurance->start_date = Carbon::parse($request->start_date);
        $insurance->end_date = Carbon::parse($request->end_date);

        if ($insurance->status->name == 'inactive') {
            $insurance->status_id = Status::where('name', 'renew_pending')->firstOrFail()->id;
            $insurance->save();
        }

        return redirect()->route('renew')->with('success', 'Seguro atualizado com sucesso!');
    }

    public function processRenew(Request $request)
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
