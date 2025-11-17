<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use App\Donation;

class DonationMail extends Mailable
{
    use Queueable, SerializesModels;
    public $donation;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Donation $donation)
    {
        $this->donation = $donation;
        $this->subject = "Donation Submission";
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.donation')->text('mail.donation');
    }
}
