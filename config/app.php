<?php

use Illuminate\Support\Facades\Facade;

return [

    'timezone' => 'America/New_York',

    'aliases' => Facade::defaultAliases()->merge([
        'Excel' => Maatwebsite\Excel\Facades\Excel::class,
        'Redis' => Illuminate\Support\Facades\Redis::class,
    ])->toArray(),

];
