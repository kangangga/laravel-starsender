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

    protected $data = [];

    public function data($data): Starsender
    {
        $this->data = $data;
        return $this;
    }

    public function getListGroup()
    {
        return static::api(__FUNCTION__);
    }

    public function relogDevice()
    {
        return static::api(__FUNCTION__);
    }

    public function sendButton($data = [])
    {
        $this->data($data);
        return static::api(__FUNCTION__, Parser::parseData($this->data, [
            'button' => Parser::button($this->data),
            'file' => $this->data['file'] ?? null,
            'footer' => $this->data['footer'] ?? null,
            'file_url' => $this->data['file_url'] ?? null,
        ]));
    }

    public function sendFilesUpload($data)
    {
        $this->data($data);
        return static::api(__FUNCTION__, function ($endpoint) {
            $file_name = File::basename($this->data['file']);
            return Http::starsender()->attach('file', file_get_contents($this->data['file']), $file_name)
                ->post($endpoint->url, Parser::parseData($this->data));
        });
    }

    public function sendFilesUrl($data = [])
    {
        $this->data($data);
        return static::api(__FUNCTION__, Parser::parseData($this->data, [
            'file' => $this->data['file_url']
        ]));
    }

    public function sendText($data = [])
    {
        $this->data($data);
        return static::api(__FUNCTION__, Parser::parseData($this->data));
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
     * @param array $this->data
     * @param string $method default POST
     * @return \Illuminate\Http\Client\Response
     */
    public function request($endpoint, $data = [], $method = 'POST')
    {
        $this->data($data);

        $this->data['button'] = Parser::buttonIf(
            array_key_exists('button', $this->data),
            $this->data
        );

        return Http::starsender()->{$method}($endpoint, $this->data);
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
