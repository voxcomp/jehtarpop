<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'event_id', 'startdate', 'name', 'contact', 'location', 'city', 'minimum', 'maximum', 'event',
    ];

    public function tickets(): HasMany
    {
        return $this->hasMany(\App\Models\Ticket::class);
    }
}
