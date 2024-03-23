<?php

return [
    'log_level' => env('REQUEST_RESPONSE_LOG_LEVEL', 'info'),

    'log_request_response' => [
        'enabled' => env('LOG_REQUEST_RESPONSE', true),
        'title' => env('LOG_REQUEST_RESPONSE_TITLE', 'Request Response'),
        'log_auth_user' => env('LOG_AUTH_USER', true),
        'log_request' => env('LOG_REQUEST', true),
        'log_response' => env('LOG_RESPONSE', true),
        'log_headers' => env('LOG_HEADERS', true),
        'log_url' => env('LOG_URL', true),
        'log_method' => env('LOG_METHOD', true),
        'log_ip' => env('LOG_IP', true),
    ],

    'log_request' => [
        'enabled' => env('LOG_REQUEST', true),
        'title' => env('LOG_REQUEST_TITLE', 'Request'),
    ],

    'log_response' => [
        'enabled' => env('LOG_RESPONSE', true),
        'title' => env('LOG_RESPONSE_TITLE', 'Response'),
    ],

    'log_headers' => [
        'enabled' => env('LOG_HEADERS', true),
        'title' => env('LOG_HEADERS_TITLE', 'Headers'),
    ],

    'columns' => [
        'request' => [
            'only' => ['*'],
            'except' => ['*']
        ],
        'response' => [
            'only' => ['*'],
            'except' => ['*']
        ]
    ],

    'urls' => [
        'only' => ['*'],
        'except' => ['*'],
    ]
];
