<?php

namespace AymanAlhattami\LogRequestResponse\Http\Middleware;

use AymanAlhattami\LogRequestResponse\LogRequest;
use AymanAlhattami\LogRequestResponse\LogResponse;
use Closure;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class LogRequestResponseMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $requestId = Str::uuid()->toString();

        $request->headers->set('X-Request-Id', $requestId);

        LogRequest::make($request)->log();

        return $next($request);
    }

    public function terminate($request, $response)
    {
        LogResponse::make($request, $response)->log();
    }
}
