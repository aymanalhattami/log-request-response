<?php

namespace AymanAlhattami\LogRequestResponse;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class LogResponse
{
    public $request;
    public $response;

    public function __construct($request, $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public static function make($request, $response): LogResponse
    {
        return new static($request, $response);
    }

    private function getResponse($response)
    {
        if (!Str::of($response->getContent())->isJson()) {
            return $response->getContent();
        } else {
            return json_decode($response->getContent(), JSON_UNESCAPED_UNICODE);
        }
    }

    public function getData(): array
    {
        $data = [
            "response" => $this->getResponse($this->response),
        ];

        if(config('log-request-response.log_response.request_id') and $this->request->headers->has('X-Request-Id')) {
            $data['request_id'] = $this->request->header('X-Request-Id');
        }

        if(config('log-request-response.log_response.auth_user')) {
            $data['auth_user'] = auth()->user();
        }

        return $data;
    }

    public function log(): void
    {
        if(config('log-request-response.log_response.enabled')) {
            $logLevel = config('log-request-response.log_level');

            Log::{$logLevel}(config('log-request-response.log_response.title'), $this->getData());
        }
    }
}