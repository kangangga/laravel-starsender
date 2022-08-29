<?php

namespace Kangangga\Starsender\Mixin;

use Illuminate\Support\Traits\Macroable;
use Illuminate\Contracts\Foundation\Application;

class BaseMixin
{
    use Macroable;

    use ApiSend,
        ApiDevice,
        ApiContact,
        ApiCampaign;

    protected Application $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }
}
