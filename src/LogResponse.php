<?php

namespace AymanAlhattami\LogRequestResponse;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
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
        return [
            'request_id' => $this->request->header('X-Request-Id'),
            "response" => $this->getResponse($this->response),
        ];
    }

    public function log(): void
    {
        if(config('log-request-response.log_response.enabled')) {
            $logLevel = config('log-request-response.log_level');

            Log::{$logLevel}(config('log-request-response.log_response.title'), $this->getData());
        }
    }
}