<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Registration;


class SendPaymentConfirmation extends Mailable
{
    use Queueable, SerializesModels;
    public $registration;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Registration $registration)
    {
        $this->registration = $registration;
        $this->subject = "GWGCI ".$registration->id." Registration Confirmation";
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.sendPaymentConfirmation');
    }
}
