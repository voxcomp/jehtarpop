<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class SupportTicketFile extends Model
{
    use Notifiable;

    public function routeNotificationForMail($notification)
    {
        if (! $this->ticket->email) {
            return null;
        }

        // Split by comma and trim whitespace
        return array_map('trim', explode(',', $this->ticket->email));
    }

    protected $fillable = [
        'filename', 'original', 'support_ticket_id',
    ];

    public function ticket()
    {
        return $this->belongsTo(SupportTicket::class, 'support_ticket_id', 'id');
    }
}
