<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Registration extends Model
{
    protected $fillable = [
        'coid', 'name', 'phone', 'address', 'city', 'state', 'zip', 'contact', 'cphone', 'cemail', 'registrantcount', 'paytype', 'paid', 'balance', 'member', 'ponum', 'regtype', 'contactfname', 'contactlname', 'responsible', 'coupon', 'discount', 'payagree', 'clientip',
    ];

    public function registrants(): HasMany
    {
        return $this->hasMany(\App\Models\Registrant::class, 'registration_id', 'id');
    }

    public function payment(): HasMany
    {
        return $this->hasMany(\App\Models\Payment::class);
    }

    public function isTrade()
    {
        return ($this->regtype == 'trade') ? true : false;
    }

    public function isEvent()
    {
        return ($this->regtype == 'event') ? true : false;
    }
}
