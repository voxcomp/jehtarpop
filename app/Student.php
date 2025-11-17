<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'coid', 'indid', 'first', 'last', 'phone', 'mobile', 'mobilecarrier', 'email', 'address', 'city', 'state', 'zip', 'balance'
    ];
}
