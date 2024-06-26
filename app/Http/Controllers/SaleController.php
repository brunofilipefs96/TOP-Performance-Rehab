<?php

namespace App\Http\Controllers;

use App\Models\Membership;
use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Stripe\Charge;
use Stripe\Event;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class SaleController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $this->authorize('viewAny', Sale::class);

        $status = $request->input('status', 'all');
        $nif = $request->input('nif', '');

        $query = Sale::query();

        if ($status !== 'all') {
            $query->whereHas('status', function ($query) use ($status) {
                $query->where('name', $status);
            });
        }

        if ($nif) {
            $query->where('nif', 'like', '%' . $nif . '%');
        }

        $query->orderBy('created_at', 'desc');

        $sales = $query->paginate(12);

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
        $payload = $request->all();
        $event = null;

        try {
            $event = Event::constructFrom($payload);
        } catch (\UnexpectedValueException $e) {
            // Invalid payload
            return response()->json(['error' => 'Invalid payload'], 400);
        }

        if ($event->type === 'payment_intent.succeeded') {
            $paymentIntent = $event->data->object;
            $sale = Sale::where('payment_intent_id', $paymentIntent->id)->first();

            if ($sale) {
                $sale->status_id = 6; // 6 represents 'paid'
                $sale->save();

                foreach ($sale->packs as $pack) {
                    $membership = Membership::where('user_id', $sale->user_id)->first();
                    if ($membership && $membership->status->name === 'active') {
                        $membership->packs()->attach($pack->id, [
                            'quantity' => $pack->trainings_number,
                            'quantity_remaining' => $pack->trainings_number,
                            'expiry_date' => Carbon::now()->addDays($pack->duration),
                        ]);
                    }
                }
            }
        }

        return response()->json(['status' => 'success']);
    }

    public function destroy(Sale $sale)
    {
        //
    }
}
