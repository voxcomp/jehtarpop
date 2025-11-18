<?php

namespace App\Mail;

use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FreePaidMail extends Mailable
{
    use Queueable, SerializesModels;

    public $payment;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Payment $payment)
    {
        $this->payment = $payment;

        $this->subject = 'Payment Submission';
    }

    /**
     * Build the message.
     */
    public function build(): static
    {
        return $this->view('mail.freePayment')->text('mail.freePaymenttext');
    }
}
