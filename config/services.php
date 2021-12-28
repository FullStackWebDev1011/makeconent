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

    'pay_u' => [
        'mode' => env('PAYU_MODE', 'sandbox'), // sandbox || secure
        'pos_id' => env('PAYU_POS_ID'),
        'signature_key' => env('PAYU_SIGNATURE_KEY'),
        'o_auth_client_id' => env('PAYU_O_AUTH_CLIENT_ID'),
        'o_auth_client_secret' => env('PAYU_O_AUTH_CLIENT_SECRET'),
        'fee' => '15', // percent (%) if not set in DB ()
        'ratelimit' => '50',
        'bonus_fee' => '7',
        'order_deadline_hours' => '7',
    ],

    'plagiarism' => [
        'url' => env('PLAGIARISM_URL', 'https://plagiarismsearch.com/api/v3'),
        'api_user' => env('PLAGIARISM_API_USER', ''),
        'api_key' => env('PLAGIARISM_API_KEY', ''),
    ],

];
