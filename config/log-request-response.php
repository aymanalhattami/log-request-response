<?php

/*
 * You can place your custom package configuration in here.
 */
return [
    'enabled' => true,
    'log_level' => 'info',
    'log_channel' => env('LOG_REQUEST_RESPONSE_CHANNEL', 'daily'),

    'enable_log_auth' => true,
    'enable_log_request' => true,
    'enable_log_response' => true,
    'enable_log_header' => true,
    'enable_log_url' => true,
    'enable_log_method' => true,
    'enable_log_ip' => true,
    'enable_log_duration' => true,

    'columns' => [
        'only' => [],
        'except' => []
    ],

    'urls' => [
        'only' => [],
        'except' => [],
    ]
];
