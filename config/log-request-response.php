<?php

return [
    'log_level' => env('REQUEST_RESPONSE_LOG_LEVEL', 'info'),

    'log_request' => [
        'enabled' => env('LOG_REQUEST', true),
        'title' => env('LOG_REQUEST_TITLE', 'Request'),
        'auth_user' => env('LOG_REQUEST_AUTH_USER', true),
        'request_id' => env('LOG_REQUEST_ID', true),
        'url' => env('LOG_REQUEST_URL', true),
        'method' => env('LOG_REQUEST_METHOD', true),
        'ip' => env('LOG_REQUEST_IP', true),
    ],

    'log_response' => [
        'enabled' => env('LOG_RESPONSE', true),
        'title' => env('LOG_RESPONSE_TITLE', 'Response'),
        'auth_user' => env('LOG_RESPONSE_AUTH_USER', true),
    ],

    'log_headers' => [
        'enabled' => env('LOG_HEADERS', true),
        'title' => env('LOG_HEADERS_TITLE', 'Headers'),
        'auth_user' => env('LOG_HEADERS_AUTH_USER', true),
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
