<?php

namespace AymanAlhattami\LogRequestResponse;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class LogResponse
{
    public Request $request;
    public Response $response;

    public function __construct($request, $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public static function make($request, $response): LogResponse
    {
        return new static($request, $response);
    }

    public function log(): void
    {
        $logLevel = config('log-request-response.log_level');

        Log::${$logLevel}('Response', [
            'request_id' => $this->request->header('X-Request-Id'),
            "response" => $this->getResponse($this->response),
        ]);
    }

    private function getResponse($response)
    {
        if (!Str::of($response->getContent())->isJson()) {
            return $response->getContent();
        } else {
            return json_decode($response->getContent(), JSON_UNESCAPED_UNICODE);
        }
    }
}