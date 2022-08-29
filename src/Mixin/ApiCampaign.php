<?php

namespace Kangangga\Starsender\Mixin;

use Illuminate\Support\Facades\Http;
use Kangangga\Starsender\Utils\Response;

trait ApiCampaign
{
    /**
     * Untuk membuat campaign baru
     * @param <device_api_key,name,syntax,welcome_message,number> $data
     * @return \Kangangga\Starsender\Utils\Response
     */
    public function createCampaign(array $data)
    {
        return new Response(
            Http::starsender()
                ->withHeaders([
                    'apiKey' => config('starsender.api_key_profile')
                ])
                ->post('/user/createCampaign', $data)
        );
    }

    /**
     * Untuk menambah anggota ke dalam campaign
     * @param <campaign_id,number,syntax,welcome_message> $data
     * @return \Kangangga\Starsender\Utils\Response
     */
    public function insertCampaign(array $data)
    {
        return new Response(
            Http::starsender()
                ->withHeaders([
                    'apiKey' => config('starsender.api_key_profile')
                ])
                ->post('/user/insertCampaign', $data)
        );
    }

    /**
     * Untuk memindah anggota campaign
     * @param <campaign_id_from,campaign_id_to,number> $data
     * @return \Kangangga\Starsender\Utils\Response
     */
    public function changeCampaign(array $data)
    {
        return new Response(
            Http::starsender()
                ->withHeaders([
                    'apiKey' => config('starsender.api_key_profile')
                ])
                ->post('/user/changeCampaign', $data)
        );
    }
}
