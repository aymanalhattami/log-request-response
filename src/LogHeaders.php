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

    public function log(): void
    {
        $logLevel = config('log-request-response.log_level');

        Log::{$logLevel}('Headers', [
            "headers" => $this->request->headers->all(),
        ]);
    }
}