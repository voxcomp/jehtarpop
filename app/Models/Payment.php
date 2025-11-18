<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'name', 'firstname', 'lastname', 'address', 'city', 'state', 'zip', 'transaction_id', 'amount', 'currency', 'payment_status', 'registration_id', 'reference', 'email',
    ];

    public function registration(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Registration::class);
    }
}
