<?php

namespace Kangangga\Starsender\Mixin;

use Illuminate\Support\Facades\Http;
use Kangangga\Starsender\Utils\Response;


trait ApiDevice
{
    /**
     * Untuk mengambil detail device seperti nama device, device id, qr code, status, server id, dll (berdasarkan device id)
     * @return \Kangangga\Starsender\Utils\Response
     */
    public function getDevice()
    {
        return new Response(
            Http::starsender()
                ->post('/v1/getDevice')
        );
    }

    /**
     * Untuk mengambil semua detail device
     * @return \Kangangga\Starsender\Utils\Response
     */
    public function getAllDevice()
    {
        return new Response(
            Http::starsender()
                ->withHeaders([
                    'apiKey' => config('starsender.api_key_profile')
                ])
                ->post('/v2/getDevice')
        );
    }


    /**
     * Untuk merelog device yang dalam case tertentu, contoh : device macet tidak bisa kirim pesan
     * @return \Kangangga\Starsender\Utils\Response
     */
    public function relogDevice()
    {
        return new Response(
            Http::starsender()
                ->post('/relogDevice')
        );
    }

    /**
     * Untuk mengambil detail pesan seperti tujuan, isi pesan, jadwal, status pengiriman, dll
     * @return \Kangangga\Starsender\Utils\Response
     */
    public function getMessage($message_id)
    {
        return new Response(
            Http::starsender()
                ->post('/getMessage', ['message_id' => $message_id])
        );
    }

    /**
     * Untuk mengambil semua data group didalam device
     * @return \Kangangga\Starsender\Utils\Response
     */
    public function groupDevice()
    {
        return new Response(
            Http::starsender()
                ->post('/device/group')
        );
    }
}
