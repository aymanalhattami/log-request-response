<?php
return [
    // Defines the logging level for recording request and response logs. Default: 'info'.
    'log_level' => env('REQUEST_RESPONSE_LOG_LEVEL', 'info'),

    'request' => [
        // Determines whether logging of HTTP requests is enabled.
        'enabled' => env('LOG_REQUEST', true),

        // Title or prefix for request logs, making them easily identifiable.
        'title' => env('LOG_REQUEST_TITLE', 'Request'),

        // Specifies whether headers should be included in the request log.
        'headers' => env('LOG_HEADERS_WITH_REQUEST', true),

        // Indicates whether the request URL should be logged.
        'url' => env('LOG_REQUEST_URL', true),

        // Determines whether the HTTP method should be logged.
        'method' => env('LOG_REQUEST_METHOD', true),

        // Specifies whether the IP address of the requester should be logged.
        'ip' => env('LOG_REQUEST_IP', true),

        // Indicates whether information about the authenticated user should be included in the request log.
        'auth_user' => env('LOG_AUTH_USER_WITH_REQUEST', true),

        // Specifies whether a unique identifier for the request should be logged.
        'request_id' => env('LOG_REQUEST_ID_WITH_REQUEST', true),

        // Specifying which request data should be logged.
        'data' => [
            'only' => ['*'], // Data to be included exclusively.
            'except' => [] // Data to be excluded.
        ],

        // Specifying which URLs should be logged.
        'urls' => [
            'only' => ['*'], // URLs to be included exclusively.
            'except' => [] // URLs to be excluded.
        ]
    ],

    'response' => [
        // Determines whether logging of HTTP responses is enabled.
        'enabled' => env('LOG_RESPONSE', true),

        // Title or prefix for response logs.
        'title' => env('LOG_RESPONSE_TITLE', 'Response'),

        // Indicates whether information about the authenticated user should be included in the response log.
        'auth_user' => env('LOG_AUTH_USER_WITH_RESPONSE', true),

        // Specifies whether the request's unique identifier should be logged with the response.
        'request_id' => env('LOG_REQUEST_ID_WITH_RESPONSE', true),

        // Specifying which response data should be logged.
        'data' => [
            'only' => ['*'], // Data to be included exclusively.
            'except' => [] // Data to be excluded.
        ]
    ],

    'headers' => [
        // Specifies whether header logging is enabled.
        'enabled' => env('LOG_HEADERS', true),

        // Title or prefix for header logs.
        'title' => env('LOG_HEADERS_TITLE', 'Headers'),

        // Indicates whether information about the authenticated user should be included in the headers log.
        'auth_user' => env('LOG_AUTH_USER_IN_HEADERS', true),
    ],

    // which data of authenticated user to be logged. Default: 'email'.
    'auth_user_column' => env('LOG_AUTH_USER_COLUMN', 'email'),

    // which guard of authenticated user to be logged. Default: 'api'.
    'auth_user_guard' => env('LOG_AUTH_USER_GUARD', 'api'),
];
