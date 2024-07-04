<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Sale;

class PaymentConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $sale;
    public $receiptUrl;

    public function __construct(Sale $sale, $receiptUrl)
    {
        $this->sale = $sale;
        $this->receiptUrl = $receiptUrl;
    }

    public function build()
    {
        return $this->subject('Payment Confirmation')
            ->view('emails.payment_confirmation');
    }
}
