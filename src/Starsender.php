<?php

namespace Kangangga\Starsender;

use Illuminate\Support\Facades\Http;
use Kangangga\Starsender\Mixin\BaseMixin;


class Starsender extends BaseMixin
{
    public function isNewVersion(array $data)
    {
        return \Arr::exists($data, 'timetable') || \Arr::exists($data, 'jadwal');
    }

    public function request($endpoint, array $data = [], $method = 'POST')
    {
        return Http::starsender()->{$method}($endpoint, $data);
    }
}
