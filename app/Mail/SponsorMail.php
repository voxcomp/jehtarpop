<?php

namespace App\Mail;
use Illuminate\Support\Facades\Storage;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use App\Donation;
use App\Sponsoritem;

class SponsorMail extends Mailable
{
    use Queueable, SerializesModels;
    public $donation;
    public $sponsoritem;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Donation $donation)
    {
        $this->donation = $donation;
        $this->sponsoritem = Sponsoritem::where('name',$donation->options)->first();
        
        $this->subject = "Donation Sponsor Submission";
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if(!empty($this->donation->logo) && Storage::disk('public')->exists('logo/'.str_replace('/storage/logo/','',$this->donation->logo))) {
            return $this->view('mail.sponsor')->attach(Storage::disk('public')->url('logo/'.str_replace('/storage/logo/','',$this->donation->logo)));
        } else {
            return $this->view('mail.sponsor');
        }
    }
}
