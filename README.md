# Log Request and Response 

[![Latest Version on Packagist](https://img.shields.io/packagist/v/aymanalhattami/log-request-response.svg?style=flat-square)](https://packagist.org/packages/aymanalhattami/log-request-response)
[![Total Downloads](https://img.shields.io/packagist/dt/aymanalhattami/log-request-response.svg?style=flat-square)](https://packagist.org/packages/aymanalhattami/log-request-response)


Log request, response, headers, method, IP address and URL

> **_NOTE:_**
Logs can be invaluable for debugging issues. By reviewing the request and response data, developers can trace what data was sent and received, and identify where things may have gone wrong

* Useful for logging APIs requests and responses
* Enable/disable logging request
* Enable/disable logging response
* Enable/disable logging headers
* You can specify which request data should be logged
* You can specify which response data should be logged
* You can specify which URLs should be logged

## Installation

You can install the package via composer:

```bash
composer require aymanalhattami/log-request-response
```

## Usage
### Log request and response

```php
use Illuminate\Support\Facades\Route;
use AymanAlhattami\LogRequestResponse\Http\Middleware\LogRequestResponseMiddleware;
use App\Http\Controllers\ExampleController;

# Log all routes
Route::middleware(LogRequestResponseMiddleware::class)->group(function() {
    // routes
});

# Log single route
Route::get('example', ExampleController::class)->middleware(LogRequestResponseMiddleware::class);
```

### Log request

```php
use Illuminate\Support\Facades\Route;
use AymanAlhattami\LogRequestResponse\Http\Middleware\LogRequestMiddleware;
use App\Http\Controllers\ExampleController;

# Log all routes
Route::middleware(LogRequestMiddleware::class)->group(function() {
    // routes
});

# Log single route
Route::get('example', ExampleController::class)->middleware(LogRequestMiddleware::class);
```

### Log response

```php
use Illuminate\Support\Facades\Route;
use AymanAlhattami\LogRequestResponse\Http\Middleware\LogResponseMiddleware;
use App\Http\Controllers\ExampleController;

# Log all routes
Route::middleware(LogResponseMiddleware::class)->group(function() {
    // routes
});

# Log single route
Route::get('example', ExampleController::class)->middleware(LogResponseMiddleware::class);
```

### Log headers

```php
use Illuminate\Support\Facades\Route;
use AymanAlhattami\LogRequestResponse\Http\Middleware\LogHeadersMiddleware;
use App\Http\Controllers\ExampleController;

# Log all routes
Route::middleware(LogHeadersMiddleware::class)->group(function() {
    // routes
});

# Log single route
Route::get('example', ExampleController::class)->middleware(LogHeadersMiddleware::class);
```

## Configuration
```php
return [
    /* Defines the logging level for recording request and response logs. Default: 'info'. */
    'log_level' => env('REQUEST_RESPONSE_LOG_LEVEL', 'info'),

    'request' => [
        /* Determines whether logging of HTTP requests is enabled. */
        'enabled' => env('LOG_REQUEST', true),

        /* Title or prefix for request logs, making them easily identifiable. */
        'title' => env('LOG_REQUEST_TITLE', 'Request'),

        /* Specifies whether headers should be included in the request log. */
        'headers' => env('LOG_HEADERS_WITH_REQUEST', true),

        /* Indicates whether the request URL should be logged. */
        'url' => env('LOG_REQUEST_URL', true),

        /* Determines whether the HTTP method should be logged. */
        'method' => env('LOG_REQUEST_METHOD', true),

        /* Specifies whether the IP address of the requester should be logged. */
        'ip' => env('LOG_REQUEST_IP', true),

        /* Indicates whether information about the authenticated user should be included in the request log. */
        'auth_user' => env('LOG_AUTH_USER_WITH_REQUEST', true),

        /* Specifies whether a unique identifier for the request should be logged. */
        'request_id' => env('LOG_REQUEST_ID_WITH_REQUEST', true),

        /**
         * Specifying which request data should be logged.
         * if 'only' has data, then 'except' will be ignored.
         * if 'except' has data, then 'only' will be ignored.
         * if both 'only' and 'except' are empty, then all data will be logged.
         * if both 'only' and 'except' are not empty, then only the data specified in 'only' will be logged.
         * if 'only' is empty, but 'except' is not empty, then all data except the data specified in 'except' will be logged.
         * if 'only' is not empty, but 'except' is empty, then only the data specified in 'only' will be logged.
         */
        'data' => [
            'only' => [],
            'except' => ['password', 'password_confirmation'],
        ],

        /**
         * Specifying which URLs should be logged.
         * if 'only' has data, then 'except' will be ignored.
         * if 'except' has data, then 'only' will be ignored.
         * if both 'only' and 'except' are empty, then all URLs will be logged.
         * if both 'only' and 'except' are not empty, then only the URLs specified in 'only' will be logged.
         * if 'only' is empty, but 'except' is not empty, then all URLs except the URLs specified in 'except' will be logged.
         * if 'only' is not empty, but 'except' is empty, then only the URLs specified in 'only' will be logged.
         */
        'urls' => [
            'only' => [],
            'except' => [],
        ]
    ],

    'response' => [
        /* Determines whether logging of HTTP responses is enabled. */
        'enabled' => env('LOG_RESPONSE', true),

        /* Title or prefix for response logs. */
        'title' => env('LOG_RESPONSE_TITLE', 'Response'),

        /* Indicates whether information about the authenticated user should be included in the response log. */
        'auth_user' => env('LOG_AUTH_USER_WITH_RESPONSE', true),

        /* Specifies whether the request's unique identifier should be logged with the response. */
        'request_id' => env('LOG_REQUEST_ID_WITH_RESPONSE', true),

        /**
         * Specifying which response data should be logged.
         * if 'only' has data, then 'except' will be ignored.
         * if 'except' has data, then 'only' will be ignored.
         * if both 'only' and 'except' are empty, then all data will be logged.
         * if both 'only' and 'except' are not empty, then only the data specified in 'only' will be logged.
         * if 'only' is empty, but 'except' is not empty, then all data except the data specified in 'except' will be logged.
         * if 'only' is not empty, but 'except' is empty, then only the data specified in 'only' will be logged.
         */
        'data' => [
            'only' => [],
            'except' => [],
        ]
    ],

    'headers' => [
        /* Specifies whether header logging is enabled. */
        'enabled' => env('LOG_HEADERS', true),

        /* Title or prefix for header logs. */
        'title' => env('LOG_HEADERS_TITLE', 'Headers'),

        /* Indicates whether information about the authenticated user should be included in the headers log. */
        'auth_user' => env('LOG_AUTH_USER_IN_HEADERS', true),
    ],

    /* which data of authenticated user to be logged. Default: 'email'. */
    'auth_user_column' => env('LOG_AUTH_USER_COLUMN', 'email'),

    /* which guard of authenticated user to be logged. Default: 'api'. */
    'auth_user_guard' => env('LOG_AUTH_USER_GUARD', 'api'),
];

```

### Testing

```bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email ayman.m.alhattami@gmail.com instead of using the issue tracker.

## Credits

-   [Ayman Alhattami](https://github.com/aymanalhattami)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).
