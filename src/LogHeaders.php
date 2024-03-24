<?php

namespace AymanAlhattami\LogRequestResponse;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LogHeaders
{
    private Request $request;
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public static function make(Request $request): LogHeaders
    {
        return new static($request);
    }

    private function getData(): array
    {
        $data = [
            "headers" => $this->request->headers->all(),
        ];

        if(config('log-request-response.headers.auth_user')) {
            $userColumn = config('log-request-response.auth_user_column');

            $data['auth_user'] = auth()->user()->{$userColumn} ?? null;
        }

        return $data;
    }

    public function log(): void
    {
        if(config('log-request-response.headers.enabled')) {
            $logLevel = config('log-request-response.log_level');

            Log::{$logLevel}(config('log-request-response.headers.title'), $this->getData());
        }
    }
}