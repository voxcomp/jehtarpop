<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sponsoritem extends Model
{
    protected $fillable = [
        'parent', 'name', 'qty', 'sold', 'price',
    ];
}
