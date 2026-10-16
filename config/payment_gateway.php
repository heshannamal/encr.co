<?php

return [

    'mode' => env('PAYMENT_MODE', 'live'), // fallback if DB is missing

    'sandbox' => [
        'login_id' => env('SANDBOX_AUTH_LOGIN_ID'),
        'transaction_key' => env('SANDBOX_AUTH_TRANSACTION_KEY'),
        'environment' => \net\authorize\api\constants\ANetEnvironment::SANDBOX,
    ],

    'live' => [
        'login_id' => env('LIVE_AUTH_LOGIN_ID'),
        'transaction_key' => env('LIVE_AUTH_TRANSACTION_KEY'),
        'environment' => \net\authorize\api\constants\ANetEnvironment::PRODUCTION,
    ],
];
