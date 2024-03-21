<?php

namespace AymanAlhattami\LogRequestResponse\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;


class LogHeadersMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $this->logHeaders($request);

        return $next($request);
    }

    private function logHeaders(Request $request)
    {
        Log::info('Header', [
            "header" => $request->headers->all(),
        ]);
    }
}
