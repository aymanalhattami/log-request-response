<?php

namespace AymanAlhattami\LogRequestResponse\Http\Middleware;

use Closure;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LogRequestResponseMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $request->start = microtime(true);
        return $next($request);
    }

    public function terminate($request, $response)
    {
        $request->end = microtime(true);
        $this->log($request, $response);
    }

    protected function log($request, $response)
    {
        $duration = $request->end - $request->start;
        $url = $request->fullUrl();
        $method = strtoupper($request->getMethod());
        $headers = $request->headers->all();
        $ip = $request->getClientIp();

        $requestedData = $request->all();
        $response = $response->getContent();

        $array = Arr::dot($requestedData);

        Log::info($url, [
            "Request"   => Arr::except($requestedData, ['identity_image1', 'identity_image2', 'selfie']),
            "Response"  => json_decode($response, JSON_UNESCAPED_UNICODE),
            "ip"        => $ip,
            "method"    => $method,
            "Duration"  => $duration . 'ms',
            "Headers"   => Arr::dot(collect($headers)),
        ]);
    }
}
