<?php

namespace AymanAlhattami\LogRequestResponse;

use AymanAlhattami\LogRequestResponse\Traits\WithMake;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LogHeaders extends BaseLog
{
    use WithMake;

    private function getData(): array
    {
        $data = [
            "headers" => $this->request->headers->all(),
        ];

        if(config('log-request-response.headers.auth_user')) {
            $userColumn = config('log-request-response.auth_user_column');

            $data['auth_user'] = auth(config('log-request-response.auth_user_guard'))->user()->{$userColumn} ?? null;
        }

        return $data;
    }

    public function log(): void
    {
        if(config('log-request-response.headers.enabled') and $this->checkUrls() and $this->checkEnvironments()) {
            $logLevel = config('log-request-response.log_level');

            Log::{$logLevel}(config('log-request-response.headers.title'), $this->getData());
        }
    }
}