<?php

namespace AymanAlhattami\LogRequestResponse;

use AymanAlhattami\LogRequestResponse\Traits\WithMake;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class LogRequest extends BaseLog
{
    use WithMake;

    public function getData(): array
    {
        if (count(config('log-request-response.request.data.only')) == 0 and count(config('log-request-response.request.data.except')) == 0) {
            $data["request"] = $this->request->all();
        } elseif (count(config('log-request-response.request.data.only')) > 0) {
            $data["request"] = Arr::only($this->request->all(), config('log-request-response.request.data.only'));
        } elseif (count(config('log-request-response.request.data.except')) > 0) {
            $data['request'] = Arr::except($this->request->all(), config('log-request-response.request.data.except'));
        } else {
            $data["request"] = [];
        }

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

            $data['auth_user'] = auth(config('log-request-response.auth_user_guard'))->user()->{$userColumn} ?? null;
        }

        return $data;
    }

    public function log(): void
    {
        if(config('log-request-response.request.enabled') and $this->checkUrls() and $this->checkEnvironments()) {
            $logLevel = config('log-request-response.log_level');

            Log::{$logLevel}(config('log-request-response.request.title'), $this->getData());
        }
    }
}