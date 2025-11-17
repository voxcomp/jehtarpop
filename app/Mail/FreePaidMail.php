<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Payment;

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
	    
	    $this->subject = "Payment Submission";
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.freePayment')->text('mail.freePaymenttext');
    }
}
