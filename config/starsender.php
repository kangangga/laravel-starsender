<?php


return [
    'enabled' => env('STARSENDER_ENABLED', true),

    'check_before_send' => env('STARSENDER_CHECK_BEFORE_SEND', false),

    'api' => [
        'url' => env('STARSENDER_API_URL', 'https://starsender.online/api'),
        'timeout' => 0,
        'connect_timeout' => 0,
        'debug' => env('STARSENDER_DEBUG', false),
        'headers' => [
            'apikey' => env('STARSENDER_API_KEY'),
        ],
    ],

    'router' => [
        'enabled' => env('STARSENDER_ROUTER_ENABLED', true),
        'prefix' => 'api/starsender',
        'middleware' => [
            \Kangangga\Starsender\Http\Middleware\StarsendeMiddleware::class
        ],
    ],

    'default_endpoint' => env('STARSENDER_ENDPOINT', 'default'),

    'endpoint' => [
        'default' => [
            'get_message' => '{{API_URL}}{{POST}}/getMessage',
            'get_device' => '{{API_URL}}{{POST}}/v1/getDevice',
            'get_list_group' => '{{API_URL}}{{POST}}/getListGroup',
            'relog_device' => '{{API_URL}}{{POST}}/relogDevice',
            'send_text' => '{{API_URL}}{{POST}}/sendText',
            'send_button' => '{{API_URL}}{{POST}}/sendButton',
            'send_files_url' => '{{API_URL}}{{POST}}/sendFiles',
            'send_files_upload' => '{{API_URL}}{{POST}}/sendFilesUpload',
            'user_create_campaign' => '{{API_URL}}{{POST}}/user/createCampaign',
            'user_insert_campaign' => '{{API_URL}}{{POST}}/user/insertCampaign',
            'user_change_campaign' => '{{API_URL}}{{POST}}/user/changeCampaign',
            'user_insert_contact' => '{{API_URL}}{{POST}}/user/insertContact',
            'user_remove_from_group' => '{{API_URL}}{{POST}}/user/removeFromGroup',
            'user_change_from_group' => '{{API_URL}}{{POST}}/user/changeGroup',
            'agency_list_package' => '{{API_URL}}{{POST}}/agency/listPackage',
            'agency_create_package' => '{{API_URL}}{{POST}}/agency/createUser',
        ]
    ],

    'webhook_handler' => '',
];
