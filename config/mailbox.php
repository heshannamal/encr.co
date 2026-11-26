<?php

return [
    'microsoft' => [
        'client_id' => env('AZURE_CLIENT_ID'),
        'client_secret' => env('AZURE_CLIENT_SECRET'),
        'redirect' => env('MAIL_MICROSOFT_REDIRECT_URI'),
        'tenant' => env('AZURE_TENANT_ID', 'common'),
    ],
    'google' => [
        'client_id' => env('MAIL_GOOGLE_CLIENT_ID'),
        'client_secret' => env('MAIL_GOOGLE_CLIENT_SECRET'),
        'redirect' => env('MAIL_GOOGLE_REDIRECT_URI'),
    ],
];
