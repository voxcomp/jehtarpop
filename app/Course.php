<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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

    public function description()
    {
        return $this->hasOne(\App\Description::class, 'courseid', 'courseid');
    }
}
