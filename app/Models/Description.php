<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Description extends Model
{
    protected $fillable = [
        'courseid', 'description',
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Course::class);
    }
}
