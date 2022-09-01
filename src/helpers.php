<?php

if (!function_exists('starsender')) {
    /** @return \Kangangga\Starsender\Starsender */
    function starsender()
    {
        return app(\Kangangga\Starsender\Starsender::class);
    }
}
