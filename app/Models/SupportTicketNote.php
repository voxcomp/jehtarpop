<?php

namespace App\Models;

use App\Observers\SupportTicketNoteObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;

#[ObservedBy([SupportTicketNoteObserver::class])]
class SupportTicketNote extends Model
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
        'description', 'support_ticket_id',
    ];

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(SupportTicket::class, 'support_ticket_id', 'id');
    }
}
