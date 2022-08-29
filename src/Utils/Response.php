<?php

namespace Kangangga\Starsender\Utils;

class Response
{
    private $object;
    private $response;

    public int $code;
    public bool $status;
    public ?int $message_id;
    public null|array|string|\stdClass $message;

    public array $result;

    public array|\Illuminate\Support\Collection $data;

    public function __construct(\Illuminate\Http\Client\Response $response)
    {
        $this->object =  $response->object();
        $this->response = $response;

        $this->__parseResponse();
    }

    public function array()
    {
        return $this->result->toArray();
    }

    public function json($options = 0)
    {
        return $this->result->toJson($options);
    }

    public function collect()
    {
        return $this->result->collect();
    }

    public function getResponse()
    {
        return $this->response;
    }

    public function getResult()
    {
        return $this->result;
    }

    public function getMessageId()
    {
        return $this->message_id;
    }

    private function __parseResponse()
    {
        $this->code = $this->response->status();
        $this->data = collect($this->object->data ?? null);
        $this->status = $this->object->status ?? $this->response->successful();
        $this->message = $this->object->message ?? null;

        if ($this->data->count() == 1) {
            $this->message_id = $this->data->first() ?? null;
        }

        $this->result = [
            'code' => $this->code,
            'data' => $this->data,
            'status' => $this->status,
            'message' => $this->message,
            'message_id' => $this->message_id,
        ];
    }

    public function __call($name, $arguments)
    {
        if (!method_exists($this, $name)) {
            if (method_exists($this->response, $name)) {
                return $this->response->{$name}($arguments);
            }
            throw new \BadMethodCallException("Method $name does not exist.");
        }

        return $this->{$name}($arguments);
    }
}
