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
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'whatsapp' => [
        'enabled'              => env('WHATSAPP_ENABLED', false),
        'token'                => env('WHATSAPP_TOKEN', ''),
        'phone_id'             => env('WHATSAPP_PHONE_ID', ''),
        'default_country_code' => env('WHATSAPP_DEFAULT_COUNTRY_CODE', '226'),
        'templates' => [
            'conge'    => env('WHATSAPP_TEMPLATE_CONGE',    'notification_rh'),
            'absence'  => env('WHATSAPP_TEMPLATE_ABSENCE',  'notification_rh'),
            'bulletin' => env('WHATSAPP_TEMPLATE_BULLETIN', 'notification_rh'),
            'document' => env('WHATSAPP_TEMPLATE_DOCUMENT', 'notification_rh'),
            'compte'   => env('WHATSAPP_TEMPLATE_COMPTE',   'notification_rh'),
            'custom'   => env('WHATSAPP_TEMPLATE_CUSTOM',   'notification_rh'),
        ],
    ],

];
