<?php


return [
    'enabled' => env('STARSENDER_ENABLED', true),
    'api_key_profile' => env('STARSENDER_API_PROFILE_KEY'),
    'check_before_send' => env('STARSENDER_CHECK_BEFORE_SEND', false),

    'api' => [
        'url' => env('STARSENDER_API_URL', 'https://starsender.online/api'),
        'timeout' => 0,
        'connect_timeout' => 0,
        'debug' => env('STARSENDER_DEBUG', false),
        'headers' => [
            'apikey' => env('STARSENDER_API_KEY'),
        ],
        'beforeSending' => \Kangangga\Starsender\Utils\BeforeSending::class,
    ],

    'router' => [
        'enabled' => env('STARSENDER_ROUTER_ENABLED', false),
        'prefix' => 'api/starsender',
        'middleware' => [],
    ],

    'webhook' => [
        'enabled' => env('STARSENDER_WEBHOOK_ENABLED', false),
        'action' => [
            \Kangangga\Starsender\Http\Controllers\WebhookController::class, 'index'
        ],
        'router' => [
            'prefix' => 'api/starsender/webhook',
            'middleware' => [],
        ]
    ],
];
