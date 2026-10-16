<?php

return [
    /*
    |--------------------------------------------------------------------------
    | API Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration options for the Order Details API
    |
    */

    'max_per_page' => 100,
    'default_per_page' => 20,
    'rate_limit' => [
        'requests_per_minute' => 60,
        'requests_per_hour' => 1000,
    ],
];
