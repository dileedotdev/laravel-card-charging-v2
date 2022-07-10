<?php

declare(strict_types=1);

// config for Dinhdjj/CardChargingV2
// `dinhdjj/laravel-card-charging-v2` package
return [
    // Default connection for thesieure
    'default' => env('THESIEURE_CONNECTION', 'default'),

    // List config connection for thesieure
    'connections' => [
        'default' => [
            'domain' => env('THESIEURE_DOMAIN', 'thesieure.com'),
            'partner_id' => env('THESIEURE_PARTNER_ID'),
            'partner_key' => env('THESIEURE_PARTNER_KEY'),
        ],
    ],
];
