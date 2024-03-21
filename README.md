# Log Request and Response 

[![Latest Version on Packagist](https://img.shields.io/packagist/v/aymanalhattami/log-request-response.svg?style=flat-square)](https://packagist.org/packages/aymanalhattami/log-request-response)
[![Total Downloads](https://img.shields.io/packagist/dt/aymanalhattami/log-request-response.svg?style=flat-square)](https://packagist.org/packages/aymanalhattami/log-request-response)

Log Request, response, headers, method, ip, duration between request and response, request start time, request end time

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

# to all routes
Route::middleware(LogHeadersMiddleware::class)->group(function() {
    // routes
});

# to single route
Route::get('example', ExampleController)->middleware(LogRequestResponseMiddleware::class);
```

### Log request

```php
use Illuminate\Support\Facades\Route;
use AymanAlhattami\LogRequestResponse\Http\Middleware\LogRequestMiddleware;

# to all routes
Route::middleware(LogRequestMiddleware::class)->group(function() {
    // routes
});

# to single route
Route::get('example', ExampleController)->middleware(LogRequestMiddleware::class);
```

### Log response

```php
use Illuminate\Support\Facades\Route;
use AymanAlhattami\LogRequestResponse\Http\Middleware\LogResponseMiddleware;

# to all routes
Route::middleware(LogResponseMiddleware::class)->group(function() {
    // routes
});

# to single route
Route::get('example', ExampleController)->middleware(LogResponseMiddleware::class);
```

### Log headers

```php
use Illuminate\Support\Facades\Route;
use AymanAlhattami\LogRequestResponse\Http\Middleware\LogHeadersMiddleware;

# to all routes
Route::middleware(LogHeadersMiddleware::class)->group(function() {
    // routes
});

# to single route
Route::get('example', ExampleController)->middleware(LogHeadersMiddleware::class);
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
