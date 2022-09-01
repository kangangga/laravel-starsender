<?php

namespace Kangangga\Starsender\Utils;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Client\Response as BaseResponse;

class Response
{
    protected $code = 404;
    protected $status = false;
    protected $message = null;
    protected $message_id = null;

    protected $data = [];

    /** @var Collection $result */
    protected $result = [];

    public function __construct($response)
    {
        $this->result = $this->parseResponse($response);
    }

    public function toArray()
    {
        return $this->result->toArray();
    }

    public function toJson($options = 0)
    {
        return $this->result->toJson($options);
    }

    public function getMessageId()
    {
        return $this->message_id;
    }

    protected function parseResponse($response): Collection
    {
        if ($response instanceof Validator) {
            $this->code = 403;
            $this->status = false;
            $this->message = $response->errors()->first();
        } else if ($response instanceof BaseResponse) {
            $result =  $response->json();
            $this->code = $response->status();
            $this->data = Arr::get($result, 'data', []);
            $this->status = Arr::get($result, 'status', $response->successful());
            $this->message = Arr::get($result, 'message');
            $this->message_id = Arr::get($this->data, 'message_id');
        }

        return new Collection([
            'code' => $this->code,
            'data' => $this->data,
            'status' => $this->status,
            'message' => $this->message,
            'message_id' => $this->message_id,
        ]);
    }
}
