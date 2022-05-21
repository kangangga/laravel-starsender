<?php

namespace Kangangga\Starsender\Utils;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Traits\Macroable;

class Endpoint
{
    use Macroable;

    public $url;
    public $name;
    public $method;
    public $base_url;
    public $endpoint;

    public function __construct($endpoint)
    {
        $this->endpoint = $endpoint;
        $this->base_url = config('starsender.api.url');
        $endpoint = Parser::replace("{{API_URL}}", config('starsender.api.url'), $endpoint);
        $this->method = Parser::method($endpoint);
        $this->url = Parser::url($endpoint, $this->method);
        $this->name = Parser::name($this->url);
    }

    public static function list()
    {
        return static::$macros;
    }

    public static function registerMacro()
    {
        $endpoints = config('starsender.endpoint');
        $default_endpoint = config('starsender.default_endpoint', 'default');
        foreach ($endpoints[$default_endpoint] as $key => $endpoint) {
            $method = Parser::camel($key);
            static::macro($method, function () use ($endpoint): Endpoint {
                return new self($endpoint);
            });
        }
    }

    public function __call($name, $arguments)
    {
        if (!property_exists($this, $name)) {
            throw new \BadMethodCallException("Method $name does not exist.");
        }

        return $this->{$name};
    }
}
