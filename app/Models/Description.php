<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Description extends Model
{
    protected $fillable = [
        'courseid', 'description',
    ];

    public function course()
    {
        return $this->belongsTo(\App\Models\Course::class);
    }
}
