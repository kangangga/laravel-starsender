<?php

namespace Kangangga\Starsender\Utils;

use Illuminate\Support\Str;

class Parser extends Str
{
    public static function has($key, $data)
    {
        return array_key_exists($key, $data);
    }

    public static function buttonIf($condition, $data)
    {
        return $condition ? static::button($data) : null;
    }

    public static function button($data)
    {

        return implode('|', $data['buttons']);
    }

    public static function url($endpoint, $method)
    {
        return (string) static::of($endpoint)->replace("{{" . $method . "}}", '');
    }

    public static function name($url)
    {
        return (string) static::of($url)
            ->replace("/", '')
            ->snake();
    }

    public static function method($endpoint)
    {
        return (string) static::of($endpoint)->after('{{')->before('}}');
    }

    public static function parseData($data, ...$otherData)
    {
        return array_merge(
            [
                'tujuan' => static::phone($data['phone']),
                'message' => $data['message'],
                'jadwal' => $data['timetable'] ?? date('Y-m-d H:i:s'),
            ],
            ...$otherData
        );
    }

    public static function phone($phone)
    {
        return "$phone.@s.whatsapp.net";
    }
}
