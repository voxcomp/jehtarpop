<?php

namespace App\Listeners;

use App\Events\RegistrationProcessed;

class SendRegistrationNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @return void
     */
    public function handle(RegistrationProcessed $event)
    {
        foreach (explode(',', getSetting('ADMIN_EMAIL', 'general')) as $email) {
            \Mail::to(trim($email))->send(new \App\Mail\RegistrationMail($event->path, $event->registration, '', false));
        }
        // \Mail::to(getSetting('ADMIN_EMAIL2','general'))->send(new \App\Mail\RegistrationMail($event->path,$event->registration,'',false));

        if (! empty($event->registration->cemail)) {
            $message = '';
            \Mail::to($event->registration->cemail)->send(new \App\Mail\RegistrationMail($event->path, $event->registration, $message, false));
            foreach ($event->registration->registrants as $registrant) {
                $message = '';
                \Mail::to($registrant->email)->send(new \App\Mail\RegistrationMail($event->path, $event->registration, $message, true, $registrant));
            }
        } else {
            $message = '';
            \Mail::to($event->registration->registrants->first()->email)->send(new \App\Mail\RegistrationMail($event->path, $event->registration, $message, true, $event->registration->registrants->first()));
        }
    }
}
