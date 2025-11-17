<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'coid', 'name', 'phone', 'address', 'city', 'state', 'zip', 'member', 'balance', 'inhouse'
    ];
}
