<?php

namespace AymanAlhattami\LogRequestResponse\Traits;

use Illuminate\Http\Request;

trait WithMake
{
    public static function make(Request $request): static
    {
        return new static($request);
    }
}