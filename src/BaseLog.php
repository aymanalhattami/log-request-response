<?php

namespace AymanAlhattami\LogRequestResponse;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

abstract class BaseLog
{
    protected Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    protected function getUrl(): string
    {
        return $this->request->fullUrl();
    }

    protected function getMethod(): string
    {
        return Str::of($this->request->getMethod())->upper();
    }

    protected function getHeaders(): array
    {
        return $this->request->headers->all();
    }

    protected function getIp(): string
    {
        return $this->request->getClientIp();
    }

    protected function checkUrls(): ?bool
    {
        $onlyUrls = array_map(function ($item) {
            return Str::of($item)->trim('/')->toString();
        }, config('log-request-response.urls.only'));

        $exceptUrls = array_map(function($item){
            return Str::of($item)->trim('/')->toString();
        }, config('log-request-response.urls.except'));

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

    protected function checkEnvironments(): bool
    {
        if(in_array(config('app.env'), config('log-request-response.environments'))) {
            return true;
        }

        return false;
    }
}