<?php

namespace AymanAlhattami\LogRequestResponse;

use Illuminate\Support\ServiceProvider;

class LogRequestResponseServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/log-request-response.php' => config_path('log-request-response.php'),
            ], 'config');
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/log-request-response.php', 'log-request-response');
    }
}
