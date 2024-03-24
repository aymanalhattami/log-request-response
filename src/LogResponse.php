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

        if(config('log-request-response.response.request_id') and $this->request->headers->has('X-Request-Id')) {
            $data['request_id'] = $this->request->header('X-Request-Id');
        }

        if(config('log-request-response.response.auth_user')) {
            $userColumn = config('log-request-response.auth_user_column');

            $data['auth_user'] = auth()->user()->{$userColumn} ?? null;
        }

        return $data;
    }

    public function log(): void
    {
        if(config('log-request-response.response.enabled')) {
            $logLevel = config('log-request-response.log_level');

            Log::{$logLevel}(config('log-request-response.response.title'), $this->getData());
        }
    }
}