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
