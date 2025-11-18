<?php

namespace App\Mail;

use App\Models\Registration;
use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EventRegistrationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $registration;

    public $messagestr = '';

    public $individual = false;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Registration $registration, $messagestr, $individual)
    {
        foreach ($registration->registrants as &$registrant) {
            $registrant->ticket = Ticket::where('ticket_id', $registrant->ticket_id)->first();
        }
        $this->registration = $registration;
        $this->messagestr = $messagestr;
        $this->individual = $individual;

        $this->subject = 'Registration';
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): static
    {
        return $this->view('mail.eventregistration')->text('mail.eventregistrationtext');
    }
}
