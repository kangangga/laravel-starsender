<?php

namespace Kangangga\Starsender\Utils;

use Illuminate\Support\Arr;
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
        $message = Arr::get($data, 'message');
        $phone = Arr::get($data, 'phone', Arr::get($data, 'tujuan'));

        $defaultData = [
            'message' => $message,
            'tujuan' => static::phone($phone),
        ];

        if (Arr::exists($data, 'timetable') || Arr::exists($data, 'jadwal')) {
            $timetable = Arr::get($data, 'timetable', Arr::get($data, 'jadwal', date('Y-m-d H:i:s')));

            if ($timetable instanceof \Illuminate\Support\Carbon) {
                $timetable = $timetable->format('Y-m-d H:i:s');
            }

            $defaultData['jadwal'] = $timetable;
        }

        if (Arr::exists($data, 'group_name')) {
            $defaultData['tujuan'] = Arr::get($data, 'group_name');
        }

        return array_merge(
            $defaultData,
            ...$otherData
        );
    }

    public static function phone($phone)
    {
        return "$phone.@s.whatsapp.net";
    }
}
