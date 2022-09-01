<?php

namespace Kangangga\Starsender;

use Illuminate\Support\Facades\Http;
use Kangangga\Starsender\Mixin\BaseMixin;


class Starsender extends BaseMixin
{
    public function isNewVersion(array $data)
    {
        $this->setData($data);
        return \Arr::exists($data, 'timetable') || \Arr::exists($data, 'jadwal');
    }

    public function request($endpoint, array $data = [], $method = 'POST')
    {
        $this->setData($data);
        return Http::starsender()->{$method}($endpoint, $data);
    }
}
