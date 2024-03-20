<?php

namespace AymanAlhattami\LogRequestResponse\Http\Middleware;

use Closure;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;


class LogRequestResponseMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $requestId = Str::uuid()->toString();

        $request->headers->set('X-Request-Id', $requestId);
        $request->headers->set('X-Start-Time', microtime(true));

        $this->logRequest($request);

        return $next($request);
    }

    private function logRequest(Request $request)
    {
        Log::info('Request', [
            'request_id' => $request->header('X-Request-Id'),
            'start_time' => now(),
            "request" => Arr::except($request->all(), ['password', 'password_confirmation']),
            "header" => $this->getHeaders($request),
            'url' => $this->getUrl($request),
            "ip" => $this->getIp($request),
            "method" => $this->getMethod($request),
            "duration" => $this->getDuration($request),
        ]);
    }

    public function terminate($request, $response)
    {
        $request->headers->set('X-End-Time', microtime(true));

        $this->logResponse($request, $response);
    }

    protected function logResponse($request, $response)
    {
        Log::info('Response', [
            'request_id' => $request->header('X-Request-Id'),
            "response" => $this->getResponse($response),
            'end_time' => now(),
            "duration" => $this->getDuration($request),
        ]);
    }

    private function getDuration($request): string
    {
        return ($request->header('X-End-Time') - $request->header('X-Start-Time')) . 'ms';
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
