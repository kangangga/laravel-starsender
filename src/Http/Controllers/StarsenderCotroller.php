<?php

namespace Kangangga\Starsender\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Kangangga\Starsender\Utils\Request;
use Kangangga\Starsender\Utils\Endpoint;
use Kangangga\Starsender\Facades\Starsender;


class StarsenderCotroller extends Controller
{
    public function index()
    {
    }


    public function list()
    {
        dd(Endpoint::list());
    }
}
