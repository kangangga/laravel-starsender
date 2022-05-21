<?php

namespace Kangangga\Starsender\Utils;

use Illuminate\Support\Str;

class Parser extends Str
{
    public static function buttonIf($condition, $data)
    {
        return $condition ? static::button($data) : null;
    }

    public static function button($data)
    {
        return implode('|', $data['button']);
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
                'timetable' => $data['timetable'] ?? '',
            ],
            ...$otherData
        );
    }

    public static function phone($phone)
    {
        return "$phone.@s.whatsapp.net";
    }
}
