<?php

namespace Kangangga\Starsender;

use File;
use Illuminate\Support\Facades\Http;
use Kangangga\Starsender\Utils\Parser;
use Illuminate\Support\Facades\Storage;
use Kangangga\Starsender\Utils\Request;
use Kangangga\Starsender\Utils\Endpoint;

class Starsender
{
    public function getListGroup()
    {
        return static::api(__FUNCTION__);
    }

    public function relogDevice()
    {
        return static::api(__FUNCTION__);
    }

    public function sendButton($data)
    {
        return static::api(__FUNCTION__, Parser::parseData($data, [
            'button' => explode('|', $data['button']),
            'file' => $data['file'] ?? null,
            'footer' => $data['footer'] ?? null,
            'file_url' => $data['file_url'] ?? null,
        ]));
    }

    public function sendFilesUpload($data)
    {
        return static::api(__FUNCTION__, function ($endpoint) use ($data) {
            $file_name = File::basename($data['file']);
            return Http::starsender()->attach('file', file_get_contents($data['file']), $file_name)
                ->post($endpoint->url, Parser::parseData($data));
        });
    }

    public function sendFilesUrl($data)
    {
        return static::api(__FUNCTION__, Parser::parseData($data, [
            'file' => $data['file_url']
        ]));
    }

    public function sendText($data)
    {
        return static::api(__FUNCTION__, Parser::parseData($data));
    }

    public function getDevice()
    {
        return static::api(__FUNCTION__);
    }

    public function getMessage($message_id)
    {
        return static::api(__FUNCTION__, ['message_id' => $message_id]);
    }

    /** Custome request endpoint
     * @param string $name
     * @param array $data
     * @param string $method default POST
     * @return \Illuminate\Http\Client\Response
     */
    public function request($endpoint, $data, $method = 'POST')
    {

        $data['button'] = Parser::buttonIf(
            array_key_exists('button', $data),
            $data
        );

        return Http::starsender()->{$method}($endpoint, $data);
    }

    /**
     * @param string $name
     * @param array|\Closure $params
     * @return \Illuminate\Http\Client\Response
     */
    protected static function api($name, $params = null)
    {
        $endpoint = Endpoint::$name();

        if ($params instanceof \Closure) {
            return $params($endpoint);
        }

        return Http::starsender()->{$endpoint->method}($endpoint->url, $params);
    }
}
