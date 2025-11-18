<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ticket extends Model
{
    protected $fillable = [
        'ticket_id', 'event_id', 'name', 'member', 'nonmember',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Event::class);
    }
}
