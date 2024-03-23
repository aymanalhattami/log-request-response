<?php

namespace AymanAlhattami\LogRequestResponse\Http\Middleware;

use AymanAlhattami\LogRequestResponse\LogHeaders;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LogHeadersMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        LogHeaders::make($request)->log();

        return $next($request);
    }
}
