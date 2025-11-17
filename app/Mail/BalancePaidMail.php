<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Payment;
use App\Student;

class BalancePaidMail extends Mailable
{
    use Queueable, SerializesModels;
	public $student;
	public $payment;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Student $student, Payment $payment)
    {
	    $this->student = $student;
	    $this->payment = $payment;
	    
	    $this->subject = "Balance Payment";
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.balancePayment')->text('mail.balancePaymenttext');
    }
}
