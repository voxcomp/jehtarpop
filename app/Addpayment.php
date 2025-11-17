<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Addpayment extends Model
{
    protected $fillable = [
        'name', 'firstname', 'lastname', 'address', 'city', 'state', 'zip', 'transaction_id', 'amount', 'currency'
    ];
}
