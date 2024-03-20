<?php

namespace AymanAlhattami\LogRequestResponse\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class LogRequestMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $this->log($request);

        return $next($request);
    }

    protected function log($request)
    {
        Log::info('Log request', [
            "request" => Arr::except($request->all(), ['password', 'password_confirmation']),
            "header" => $this->getHeaders($request),
            'url' => $this->getUrl($request),
            "ip" => $this->getIp($request),
            "method" => $this->getMethod($request),
        ]);
    }

    private function getUrl($request): string
    {
        return $request->fullUrl();
    }

    private function getMethod($request): string
    {
        return Str::of($request->getMethod())->upper();
    }

    private function getHeaders($request): array
    {
        return $request->headers->all();
    }

    private function getIp($request): string
    {
        return $request->getClientIp();
    }
}
