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
        if(config('log-request-response.request.enabled') and $this->checkUrlConfig()) {
            $logLevel = config('log-request-response.log_level');

            Log::{$logLevel}(config('log-request-response.request.title'), $this->getData());
        }
    }

    private function checkUrlConfig(): ?bool
    {
        $onlyUrls = config('log-request-response.urls.only');
        $exceptUrls = config('log-request-response.urls.except');
        $currentPath = $this->request->path();
        $result = null;

        if (empty($onlyUrls) && empty($exceptUrls)) {
            $result = true;
        } elseif (filled($onlyUrls)) {
            if(in_array($currentPath, $onlyUrls)) {
                $result = true;
            } else {
                foreach ($onlyUrls as $onlyUrl) {
                    $onlyUrl = Str::of($onlyUrl)->trim('/');
                    if (Str::endsWith($onlyUrl, '*') and Str::of($currentPath)->contains(Str::of($onlyUrl)->trim('*')->trim('/')->toString())) {
                        $result = true;
                        break;
                    }
                }

                if(is_null($result)) {
                    $result = false;
                }
            }
        } elseif (filled($exceptUrls)) {
            if(in_array($currentPath, $exceptUrls)) {
                $result = false;
            } else {
                foreach ($exceptUrls as $exceptUrl) {
                    $exceptUrl = Str::of($exceptUrl)->trim('/');
                    if (Str::endsWith($exceptUrl, '*') and Str::of($currentPath)->contains(Str::of($exceptUrl)->trim('*'))) {
                        $result = false;
                        break;
                    }
                }

                if(is_null($result)) {
                    $result = true;
                }
            }
        }

        return $result;
    }

}