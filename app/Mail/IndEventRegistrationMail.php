<?php

namespace App\Mail;

use App\Registrant;
use App\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class IndEventRegistrationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $registrant;

    public $messagestr;

    public $individual;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Registrant $registrant, $messagestr, $individual)
    {
        $registrant->ticket = Ticket::where('ticket_id', $registrant->ticket_id)->first();
        $this->registrant = $registrant;
        $this->messagestr = $messagestr;
        $this->individual = $individual;

        $this->subject = 'Class Registration';
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.indeventregistration')->text('mail.indeventregistrationtext');
    }
}
