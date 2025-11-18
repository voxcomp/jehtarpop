<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Course extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'schoolyear', 'location', 'trade', 'courseid', 'member', 'nonmember', 'coursedesc', 'tradedesc',
    ];

    public function description(): HasOne
    {
        return $this->hasOne(\App\Models\Description::class, 'courseid', 'courseid');
    }
}
