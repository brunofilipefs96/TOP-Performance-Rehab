<?php

namespace App\Http\Controllers;

use App\Models\Membership;
use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Charge;
use Stripe\Event;
use Stripe\PaymentIntent;
use Stripe\Stripe;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\PaymentConfirmation;

class SaleController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $this->authorize('viewAny', Sale::class);

        $status = $request->input('status', 'all');
        $nif = $request->input('nif', '');

        $query = Sale::query();

        if (!Auth::user()->hasRole('admin')) {
            $query->where('user_id', Auth::id());
        }

        if ($status !== 'all') {
            $query->whereHas('status', function ($query) use ($status) {
                $query->where('name', $status);
            });
        }

        if ($nif) {
            $query->where('nif', 'like', '%' . $nif . '%');
        }

        $query->orderBy('created_at', 'desc');

        $sales = $query->paginate(12)->appends([
            'status' => $status,
            'nif' => $nif
        ]);

        return view('pages.sales.index', ['sales' => $sales, 'status' => $status, 'nif' => $nif]);
    }


    public function show(Sale $sale)
    {
        $this->authorize('view', $sale);

        Stripe::setApiKey(env('STRIPE_SECRET'));

        $paymentIntent = PaymentIntent::retrieve($sale->payment_intent_id);

        $paymentStatus = $paymentIntent->status;
        $paymentReference = null;
        $paymentEntity = null;
        $amount = $paymentIntent->amount / 100;
        $paymentVoucherUrl = null;
        $receiptUrl = null;

        if ($paymentStatus !== 'succeeded') {
            if (isset($paymentIntent->next_action->multibanco_display_details)) {
                $paymentReference = $paymentIntent->next_action->multibanco_display_details->reference;
                $paymentEntity = $paymentIntent->next_action->multibanco_display_details->entity;
                $paymentVoucherUrl = $paymentIntent->next_action->multibanco_display_details->hosted_voucher_url;
            }
        } else {
            $chargeId = $paymentIntent->latest_charge;
            if ($chargeId) {
                $charge = Charge::retrieve($chargeId);
                $receiptUrl = $charge->receipt_url ?? null;
            }
        }

        return view('pages.sales.show', [
            'sale' => $sale,
            'paymentStatus' => $paymentStatus,
            'paymentReference' => $paymentReference,
            'paymentEntity' => $paymentEntity,
            'amount' => $amount,
            'paymentVoucherUrl' => $paymentVoucherUrl,
            'receiptUrl' => $receiptUrl,
        ]);
    }

    public function handleWebhook(Request $request)
    {
        Log::info('Webhook received');

        // Defina a chave da API do Stripe
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        $payload = $request->all();
        $event = null;

        try {
            $event = \Stripe\Event::constructFrom($payload);
            Log::info('Stripe event constructed successfully');
        } catch (\UnexpectedValueException $e) {
            Log::error('Invalid payload');
            return response()->json(['error' => 'Invalid payload'], 400);
        }

        if ($event->type === 'payment_intent.succeeded') {
            Log::info('Payment Intent Succeeded');
            $paymentIntent = $event->data->object;
            Log::info('Payment Intent Object: ' . json_encode($paymentIntent));

            $sale = Sale::where('payment_intent_id', $paymentIntent->id)->first();

            if ($sale) {
                Log::info('Sale found: ' . $sale->id);
                $sale->status_id = 6;
                $sale->save();
                Log::info('Sale status updated to paid');

                if ($sale->products()->count() == 0 && $sale->packs()->count() == 0) {
                    $membership = Membership::where('user_id', $sale->user_id)->first();
                    if ($membership) {
                        $membership->status_id = 2;
                        $membership->start_date = Carbon::now();
                        $membership->end_date = Carbon::now()->addYear();
                        $membership->save();
                        Log::info('Membership status updated to active with start and end dates');

                        $insurance = $membership->insurance;
                        if ($insurance) {
                            $insurance->status_id = 2;
                            $insurance->save();
                            Log::info('Insurance status updated to active');
                        }
                    }
                }

                foreach ($sale->packs as $pack) {
                    $membership = Membership::where('user_id', $sale->user_id)->first();
                    if ($membership && $membership->status->name === 'active') {
                        $membership->packs()->attach($pack->id, [
                            'quantity' => $pack->trainings_number,
                            'quantity_remaining' => $pack->trainings_number,
                            'expiry_date' => Carbon::now()->addDays($pack->duration),
                        ]);
                        Log::info('Pack processed and attached to membership');
                    }
                }

                $paymentStatus = $paymentIntent->status;
                $paymentReference = null;
                $paymentEntity = null;
                $amount = $paymentIntent->amount / 100;
                $paymentVoucherUrl = null;
                $receiptUrl = null;

                if ($paymentStatus !== 'succeeded') {
                    if (isset($paymentIntent->next_action->multibanco_display_details)) {
                        $paymentReference = $paymentIntent->next_action->multibanco_display_details->reference;
                        $paymentEntity = $paymentIntent->next_action->multibanco_display_details->entity;
                        $paymentVoucherUrl = $paymentIntent->next_action->multibanco_display_details->hosted_voucher_url;
                    }
                } else {
                    $chargeId = $paymentIntent->latest_charge;
                    if ($chargeId) {
                        $charge = \Stripe\Charge::retrieve($chargeId);
                        $receiptUrl = $charge->receipt_url ?? null;
                    }
                }

                try {
                    $isEnrollmentFee = ($sale->products()->count() == 0 && $sale->packs()->count() == 0);
                    Mail::to($sale->user->email)->send(new PaymentConfirmation($sale, $receiptUrl, $isEnrollmentFee));
                    Log::info('Payment confirmation email sent to: ' . $sale->user->email);
                } catch (\Exception $e) {
                    Log::error('Failed to send payment confirmation email: ' . $e->getMessage());
                }
            } else {
                Log::error('Sale not found for Payment Intent ID: ' . $paymentIntent->id);
            }
        }

        return response()->json(['status' => 'success']);
    }
    public function destroy(Sale $sale)
    {
        //
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status_id' => 'required|exists:statuses,id',
        ]);

        $sale = Sale::findOrFail($id);

        if ($sale->status_id == 6 && $request->status_id == 8) {
            $sale->status_id = $request->status_id;
            $sale->save();

            return redirect()->route('sales.show', $id)->with('success', 'Estado da encomenda atualizado com sucesso.');
        }

        return redirect()->route('sales.show', $id)->with('error', 'Não é possível atualizar o estado da encomenda.');
    }

}
