<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;

class Registrant extends Model
{
    protected $fillable = [
        'registration_id', 'firstname', 'lastname', 'mobile', 'mobilecarrier', 'dob', 'address', 'city', 'state', 'zip', 'email', 'program', 'location', 'course', 'fee', 'companypaid', 'event_id', 'event', 'ticket_id', 'ticket', 'das', 'map', 'indid', 'schoolyear',
    ];

    public function registration(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Registration::class);
    }

    public function myticket(): HasOne
    {
        return $this->hasOne(\App\Models\Ticket::class, 'ticket_id', 'id');
    }
}
