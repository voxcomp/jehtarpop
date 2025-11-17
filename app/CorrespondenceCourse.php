<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CorrespondenceCourse extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'schoolyear', 'location', 'trade', 'courseid', 'member', 'nonmember', 'coursedesc', 'tradedesc'
    ];
}
