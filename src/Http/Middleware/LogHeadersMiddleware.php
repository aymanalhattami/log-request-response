<?php

namespace AymanAlhattami\LogRequestResponse\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class LogHeadersMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $this->logHeaders($request);

        return $next($request);
    }

    private function logHeaders(Request $request)
    {
        Log::info('Headers', [
            "headers" => $request->headers->all(),
        ]);
    }
}
