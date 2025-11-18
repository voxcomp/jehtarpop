<?php

namespace App\Mail;

use App\Models\Registrant;
use App\Models\Registration;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegistrationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $registration;

    public $messagestr = '';

    public $individual = false;

    public $registrant;

    public $path = 'event';

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($path, Registration $registration, $messagestr, $individual, ?Registrant $registrant = null)
    {
        $this->registration = $registration;
        $this->messagestr = $messagestr;
        $this->individual = $individual;
        $this->path = $path;
        $this->registrant = $registrant;

        $this->subject = ucfirst($path).' Registration';
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): static
    {
        return $this->view('mail.registration')->text('mail.registrationtext');
    }
}
