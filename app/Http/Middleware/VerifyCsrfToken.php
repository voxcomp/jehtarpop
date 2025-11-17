<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'registration/*/payment/complete',
        'registration/*/payment/complete/*',
        'registration/online/payment/complete/*',
        'registration/trade/payment/complete/*',
        'registration/{path}/payment/complete/{registration}',
        'donation/payment/{donation}',
        'donation/payment/*',
        'sponsor/payment/{donation}',
        'sponsor/payment/*',
    ];
}
