<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'event_id', 'startdate', 'name', 'contact', 'location', 'city', 'minimum', 'maximum', 'event',
    ];

    public function tickets()
    {
        return $this->hasMany(\App\Ticket::class);
    }
}
