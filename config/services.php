<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],
    'o365' => [
        'clientId' => '8f86219b-1f18-4179-ad0f-410b8ed0f78c',
        'clientSecret' => '81ae2fab-bf7d-474e-9e75-c858ee09770b',
        'redirectUri' => 'https://encorecustom.cloud/emails',
    ],
    'azure' => [
        'client_id' => env('AZURE_CLIENT_ID'),
        'client_secret' => env('AZURE_CLIENT_SECRET'),
        'redirect' => env('AZURE_REDIRECT_URI'),
        'tenant' => env('AZURE_TENANT_ID'),
        'with_refresh_token' => true,
    ],
    'shippo' => [
        'key' => env('SHIPPO_API_KEY')
    ],
    'qbo' => [
        'client_id' => env('QBO_CLIENT_ID'),
        'client_secret' => env('QBO_CLIENT_SECRET'),
        'redirect_uri' => env('QBO_REDIRECT_URI'),
        'environment' => env('QBO_ENVIRONMENT', 'sandbox'),
    ],

    'zoom' => [
        'client_id' => env('ZOOM_CLIENT_ID'),
        'client_secret' => env('ZOOM_CLIENT_SECRET'),
        'redirect_uri' => env('ZOOM_REDIRECT_URI'),
    ],

    'usps' => [
        'oauth_url' => env('USPS_OAUTH_URL', 'https://apis.usps.com'),
        'payment_url' => env('USPS_PAYMENT_URL', 'https://apis.usps.com'),
        'api_url' => env('USPS_API_URL', 'https://apis.usps.com'),

        'consumer_key' => env('USPS_CONSUMER_KEY'),
        'consumer_secret' => env('USPS_CONSUMER_SECRET'),
        'origin_zip' => env('USPS_ORIGIN_ZIP'),

        'crid' => env('USPS_CRID'),
        'mid' => env('USPS_MID'),
        'manifest_mid' => env('USPS_MANIFEST_MID'),
        'account_type' => env('USPS_ACCOUNT_TYPE', 'EPS'),
        'account_number' => env('USPS_ACCOUNT_NUMBER'),
    ],
    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect' => env('GOOGLE_REDIRECT_URI'),
    ],
];
