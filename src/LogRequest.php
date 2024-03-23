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
            "headers" => $this->getHeaders(),
            'url' => $this->getUrl(),
            "ip" => $this->getIp(),
            "method" => $this->getMethod(),
        ];

        if($this->request->headers->has('X-Request-Id')) {
            $data['request_id'] = $this->request->header('X-Request-Id');
        }

        return $data;
    }

    public function log(): void
    {
        if(config('log-request-response.log_request.enabled')) {
            $logLevel = config('log-request-response.log_level');

            Log::{$logLevel}(config('log-request-response.log_request.title'), $this->getData());
        }
    }
}