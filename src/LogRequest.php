<?php

namespace AymanAlhattami\LogRequestResponse;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class LogRequest
{
    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public static function make(Request $request): LogRequest
    {
        return new static($request);
    }

    private function getUrl(): string
    {
        return $this->request->fullUrl();
    }

    private function getMethod(): string
    {
        return Str::of($this->request->getMethod())->upper();
    }

    private function getHeaders(): array
    {
        return $this->request->headers->all();
    }

    private function getIp(): string
    {
        return $this->request->getClientIp();
    }

    public function getData(): array
    {
        $data = [
            "request" => Arr::except($this->request->all(), ['password', 'password_confirmation']),
        ];

        if(config('log-request-response.request.method')) {
            $data['method'] = $this->getMethod();
        }

        if(config('log-request-response.request.url')) {
            $data['url'] = $this->getUrl();
        }

        if(config('log-request-response.request.ip')) {
            $data['ip'] = $this->getIp();
        }

        if(config('log-request-response.request.request_id') and $this->request->headers->has('X-Request-Id')) {
            $data['request_id'] = $this->request->header('X-Request-Id');
        }

        if(config('log-request-response.request.headers')) {
            $data["headers"] = $this->getHeaders();
        }

        if(config('log-request-response.request.auth_user')) {
            $userColumn = config('log-request-response.auth_user_column');

            $data['auth_user'] = auth()->user()->{$userColumn} ?? null;
        }

        return $data;
    }

    public function log(): void
    {
        if(config('log-request-response.request.enabled')) {
            $logLevel = config('log-request-response.log_level');

            Log::{$logLevel}(config('log-request-response.request.title'), $this->getData());
        }
    }
}