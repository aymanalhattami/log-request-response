<?php

namespace AymanAlhattami\LogRequestResponse\Http\Middleware;

use AymanAlhattami\LogRequestResponse\LogResponse;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class LogResponseMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        return $next($request);
    }

    public function terminate($request, $response)
    {
        LogResponse::make($request, $response)->log();
    }

}
