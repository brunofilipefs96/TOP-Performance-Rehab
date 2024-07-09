<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PaymentReferenceMail extends Mailable
{
    use Queueable, SerializesModels;

    public $sale;
    public $paymentReference;
    public $paymentEntity;
    public $amount;

    public function __construct($sale, $paymentReference, $paymentEntity, $amount)
    {
        $this->sale = $sale;
        $this->paymentReference = $paymentReference;
        $this->paymentEntity = $paymentEntity;
        $this->amount = $amount;
    }

    public function build()
    {
        return $this->subject('Referência de Pagamento Multibanco')
            ->view('emails.payment_reference')
            ->with([
                'sale' => $this->sale,
                'paymentReference' => $this->paymentReference,
                'paymentEntity' => $this->paymentEntity,
                'amount' => $this->amount,
            ]);
    }
}
