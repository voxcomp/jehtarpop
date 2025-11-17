<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    protected $fillable = [
        'fname', 'lname', 'title', 'company', 'email', 'phone', 'address', 'city', 'state', 'zip', 'amount', 'paytype', 'amount', 'paid', 'cardno', 'cardtype', 'clientip', 'options', 'sponsor', 'logo',
    ];

    public function isSponsor()
    {
        return ($this->sponsor == 1) ? true : false;
    }
}
