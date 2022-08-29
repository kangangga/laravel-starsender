<?php

namespace Kangangga\Starsender\Utils;

use Illuminate\Http\Client\Request;
use Illuminate\Http\Client\PendingRequest;

class BeforeSending
{
    public static function sending(Request $request, array $config, PendingRequest $pendingRequest)
    {

        return $request;
    }
}
