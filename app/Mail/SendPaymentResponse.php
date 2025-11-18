<?php

namespace App\Mail;

use App\Models\Registration;
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
     */
    public function build(): static
    {
        return $this->view('mail.sendPaymentResponse');
    }
}
