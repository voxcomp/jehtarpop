<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    protected $fillable = [
        'coid', 'name', 'phone', 'address', 'city', 'state', 'zip', 'contact', 'cphone', 'cemail', 'registrantcount', 'paytype', 'paid', 'balance', 'member', 'ponum', 'regtype', 'contactfname', 'contactlname', 'responsible', 'coupon', 'discount', 'payagree', 'clientip',
    ];

    public function registrants()
    {
        return $this->hasMany(\App\Registrant::class, 'registration_id', 'id');
    }

    public function payment()
    {
        return $this->hasMany(\App\Payment::class);
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
