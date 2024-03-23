<?php

namespace AymanAlhattami\LogRequestResponse\Http\Middleware;

use AymanAlhattami\LogRequestResponse\LogRequest;
use Closure;
use Illuminate\Http\Request;

class LogRequestMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        LogRequest::make($request)->log();

        return $next($request);
    }

}
