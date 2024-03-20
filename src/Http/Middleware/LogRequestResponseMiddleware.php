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
        $request->id = Str::uuid();

        $this->logRequest($request);

        return $next($request);
    }

    private function logRequest(Request $request)
    {
        Log::info('Request', [
            'id' => $request->id,
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
        $request->end_time = microtime(true);

        $this->logResponse($request, $response);
    }

    protected function logResponse($request, $response)
    {
        Log::info('Response', [
            "response" => $this->getResponse($response),
            'end_time' => now(),
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
