<?php

namespace Kangangga\Starsender\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Kangangga\Starsender\Utils\Request;
use Kangangga\Starsender\Utils\Endpoint;
use Kangangga\Starsender\Facades\Starsender;


class StarsenderController extends Controller
{
    public function list()
    {
        dd(Endpoint::list());
    }
}
