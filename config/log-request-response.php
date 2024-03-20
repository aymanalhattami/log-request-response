<?php

return [
    'enabled' => true,
    'log_level' => 'info',

    'enable_log_auth' => true,
    'enable_log_request' => true,
    'enable_log_response' => true,
    'enable_log_header' => true,
    'enable_log_url' => true,
    'enable_log_method' => true,
    'enable_log_ip' => true,
    'enable_log_duration' => true,

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
        'only' => [],
        'except' => [],
    ]
];
