<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
        'ticket_id', 'event_id', 'name', 'member', 'nonmember',
    ];

    public function event()
    {
        return $this->belongsTo(\App\Event::class);
    }
}
