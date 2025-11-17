<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Registrant;

class IndRegistrationMail extends Mailable
{
    use Queueable, SerializesModels;
	public $registrant;
	public $messagestr;
	public $individual;
	public $path='event';

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($path, Registrant $registrant, $messagestr, $individual)
    {
	    $this->registrant = $registrant;
	    $this->messagestr = $messagestr;
	    $this->individual = $individual;
	    $this->path = $path
	    
	    $this->subject = (($path=='trade')?'Trade ':'')."Class Registration";
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.indregistration')->text('mail.indregistrationtext');
    }
}
