<?php

namespace Kangangga\Starsender\Mixin;

use Illuminate\Support\Traits\Macroable;
use Illuminate\Contracts\Foundation\Application;

class BaseMixin
{
    use Macroable,
        ApiSend,
        ApiDevice,
        ApiContact,
        ApiCampaign;

    protected $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }
}
