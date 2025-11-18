<?php

namespace App\Mail;

use App\Models\Payment;
use App\Models\Student;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

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

        $this->subject = 'Balance Payment';
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): static
    {
        return $this->view('mail.balancePayment')->text('mail.balancePaymenttext');
    }
}
