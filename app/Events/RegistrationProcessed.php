<?php

namespace App\Events;

use App\Registration;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RegistrationProcessed
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $registration;

    public $path;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($path, Registration $registration)
    {
        $this->registration = $registration;
        $this->path = $path;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('registration');
    }
}
