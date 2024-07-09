<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $sale;
    public $receiptUrl;
    public $isEnrollmentFee;

    public function __construct($sale, $receiptUrl, $isEnrollmentFee = false)
    {
        $this->sale = $sale;
        $this->receiptUrl = $receiptUrl;
        $this->isEnrollmentFee = $isEnrollmentFee;
    }

    public function build()
    {
        return $this->subject('Confirmação de Pagamento')
            ->view('emails.payment_confirmation')
            ->with([
                'sale' => $this->sale,
                'receiptUrl' => $this->receiptUrl,
                'isEnrollmentFee' => $this->isEnrollmentFee,
            ]);
    }
}
