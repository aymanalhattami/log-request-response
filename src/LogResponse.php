<?php

namespace AymanAlhattami\LogRequestResponse;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class LogResponse extends BaseLog
{
    public $response;

    public function __construct($request, $response)
    {
        parent::__construct($request);

        $this->response = $response;
    }

    public static function make($request, $response): static
    {
        return new static($request, $response);
    }

    private function getResponse()
    {
        if (!Str::of($this->response->getContent())->isJson()) {
            return $this->response->getContent();
        } else {
            return json_decode($this->response->getContent(), JSON_UNESCAPED_UNICODE);
        }
    }

    public function getData(): array
    {
        if (count(config('log-request-response.response.data.only')) == 0 and count(config('log-request-response.response.data.except')) == 0) {
            $data["response"] = $this->getResponse();
        } elseif (count(config('log-request-response.response.data.only')) > 0) {
            $data["response"] = Arr::only($this->getResponse(), config('log-request-response.response.data.only'));
        } elseif (count(config('log-request-response.response.data.except')) > 0) {
            $data['response'] = Arr::except($this->getResponse(), config('log-request-response.response.data.except'));
        } else {
            $data["response"] = [];
        }

        if(config('log-request-response.response.request_id') and $this->request->headers->has('X-Request-Id')) {
            $data['request_id'] = $this->request->header('X-Request-Id');
        }

        if(config('log-request-response.response.auth_user')) {
            $userColumn = config('log-request-response.auth_user_column');

            $data['auth_user'] = auth(config('log-request-response.auth_user_guard'))->user()->{$userColumn} ?? null;
        }

        return $data;
    }

    public function log(): void
    {
        if(config('log-request-response.response.enabled') and $this->checkUrls() and $this->checkEnvironments()) {
            $logLevel = config('log-request-response.log_level');

            Log::{$logLevel}(config('log-request-response.response.title'), $this->getData());
        }
    }
}