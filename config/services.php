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

    'denizbank' => [
        'endpoint' => env('DENIZBANK_ENDPOINT', 'https://sanaltest.denizbank.com/mpi/Default.aspx'),
        'shopcode' => env('DENIZBANK_SHOPCODE', '3123'),
        'usercode' => env('DENIZBANK_USERCODE', 'InterTestApi'),
        'userpass' => env('DENIZBANK_USERPASS', '3'),
        'currencycode' => env('DENIZBANK_CURRENCYCODE', '840'),
    ]

];
