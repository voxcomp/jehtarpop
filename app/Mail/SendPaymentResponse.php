<?php

namespace App\Mail;

use App\Registration;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendPaymentResponse extends Mailable
{
    use Queueable, SerializesModels;

    public $registration;

    public $response;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Registration $registration, $response)
    {
        $this->registration = $registration;
        $this->response = $response;
        $this->subject = 'GWGCI '.$registration->id.' Registration Payment';
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.sendPaymentResponse');
    }
}
