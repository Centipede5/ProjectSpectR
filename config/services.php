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
    'igdb' => [
        'key' => env('IGDB_KEY'),
        'url' => env('IGDB_URL')
    ],
    'igdbv3' => [
        'key' => env('IGDBv3_KEY'),
        'url' => env('IGDBv3_URL')
    ],
    'psnapi' => [
        'url' => env('PSNAPI_URL')
    ],
    'xboxapi' => [
        'url' => env('XBOXAPI_URL'),
        'games_array_url' => env('XBOXAPI_GAMES_ARRAY_URL'),
    ],
    'ninapi' => [
        'url' => env('NINAPI_URL')
    ]
];
