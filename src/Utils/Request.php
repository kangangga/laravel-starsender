<?php

namespace Kangangga\Starsender\Utils;

use Http;
use Illuminate\Support\Str;

class Request
{

    public string $url;
    public string $name;
    public string $method;
    public object $config;
    public string $endpoint;

    public bool $direct_request = true;

    public \Illuminate\Support\Collection $parameters;

    public function __construct($endpoint, $parameters)
    {
        $this->endpoint = $endpoint;
        $this->parameters = collect($parameters);
        $this->config = (object) config('starsender.api');

        $this->setMethodUrl();

        if (config('starsender.check_before_send')) {
            Endpoint::checkServer();
        }

        // if ($this->direct_request) {
        //     $this->directRequest();
        // }
    }

    protected function directRequest()
    {
        $this->reponse = Http::starsender()
            ->{$this->method}($this->url);
    }

    public function parameters($parameters)
    {
        $this->parameters = collect($parameters);
        return $this;
    }

    public function reponse()
    {
        if (func_num_args() === 0) {
            return $this->reponse->json();
        }

        return $this->reponse;
    }

    public function request()
    {
        return Http::starsender()
            ->{$this->method}($this->url);
    }

    private function setMethodUrl()
    {
        $this->method = (string) Str::of($this->endpoint)->after('{')->before('}');
        $this->url = (string) Str::of($this->endpoint)->replace("{{$this->method}}", '');
        $this->name = (string) Str::of($this->url)
            ->replace("/", '')
            ->snake();
    }

    public function __call($name, $arguments)
    {
        if (!property_exists($this, $name)) {
            throw new \BadMethodCallException("Method $name does not exist.");
        }

        return $this->{$name};
    }
}
