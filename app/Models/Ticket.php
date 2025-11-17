<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
        'ticket_id', 'event_id', 'name', 'member', 'nonmember',
    ];

    public function event()
    {
        return $this->belongsTo(\App\Models\Event::class);
    }
}
