<?php

namespace Kangangga\Starsender\Mixin;

use Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Traits\Macroable;
use Kangangga\Starsender\Utils\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Foundation\Application;

class BaseMixin
{
    use Macroable;

    use ApiSend,
        ApiDevice,
        ApiContact,
        ApiCampaign;

    public $data = [];

    protected Application $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function response($result)
    {
        return new Response($result);
    }

    public function responseWithValidator($httpClient, ...$validation)
    {
        $rules = collect(Arr::get($validation, 0, []));
        $message = collect(Arr::get($validation, 1, []));
        $customAttributes = collect(Arr::get($validation, 2, []));

        $message->put('phone.regex', 'Phone :input format is invalid.');

        $validator = Validator::make(
            $this->data,
            $rules->toArray(),
            $message->toArray(),
            $customAttributes->toArray(),
        );

        if ($validator->stopOnFirstFailure()->fails()) {
            return $this->response($validator);
        }

        return $this->response($httpClient);
    }

    public function phoneValidation()
    {
        return 'required|regex:/^(08)+[0-9]/|regex:/^[0-9]+$/';
    }

    public function setData(array $data)
    {
        $this->data = $data;

        return $this;
    }
}
