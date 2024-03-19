<?php

namespace AymanAlhattami\LogRequestResponse\Http\Middleware;

use Closure;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

use function PHPSTORM_META\type;
use function Psy\debug;

class LogRequestResponseMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $request->start_time = microtime(true);
        return $next($request);
    }

    public function terminate($request, $response)
    {
        $request->end_time = microtime(true);

        $this->log($request, $response);
    }

    protected function log($request, $response)
    {
        Log::info('Log request and response', [
            "request" => Arr::except($request->all(), ['password', 'password_confirmation']),
            "response" => $this->getResponse($response),
            "header" => $this->getHeaders($request),
            'url' => $this->getUrl($request),
            "ip" => $this->getIp($request),
            "method" => $this->getMethod($request),
            "duration" => $this->getDuration($request),
        ]);
    }

    private function getDuration($request): string
    {
        return ($request->end_time - $request->start_time) . 'ms';
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

    private function getResponse($response)
    {
        if (!Str::of($response->getContent())->isJson()) {
            return $response->getContent();
        } else {
            return json_decode($response->getContent(), JSON_UNESCAPED_UNICODE);
        }
    }
}
