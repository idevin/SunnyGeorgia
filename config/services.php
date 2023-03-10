<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'prostorsms' => [
        'login' => env('PROSTORSMS_LOGIN'),
        'password' => env('PROSTORSMS_PASSWORD'),
        'url' => env('PROSTORSMS_URL'),
    ],
    'facebook' => [
        'client_id' => env('FCB_CLIENT_ID'),         // Your GitHub Client ID
        'client_secret' => env('FCB_CLIENT_SECRET'), // Your GitHub Client Secret
        'redirect' => '/login/facebook/callback',
    ],
    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),         // Your GitHub Client ID
        'client_secret' => env('GOOGLE_CLIENT_SECRET'), // Your GitHub Client Secret
        'redirect' => '/login/google/callback',
    ],

    'smscru' => [
        'login'  => env('SMSCRU_LOGIN'),
        'secret' => env('SMSCRU_SECRET'),
        'sender' => env('APP_NAME')
    ],

];
