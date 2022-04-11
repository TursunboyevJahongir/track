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

    'google' => [
        'client_id' => '321212311983-as1p85tva9dr2jevtvrbfgensdffnslm.apps.googleusercontent.com',
        'client_secret' => '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',
        'redirect' => 'http://trackloc.uz/auth/google/callback',
    ],
    'facebook' => [
        'client_id' => '1061207521497021', //USE FROM FACEBOOK DEVELOPER ACCOUNT
        'client_secret' => '45b945926ab6b5fdb97d9c258df52bef', //USE FROM FACEBOOK DEVELOPER ACCOUNT
        'redirect' => 'http://trackloc.uz/facebook/callback'
    ],
];
