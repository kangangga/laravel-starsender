<?php

namespace Kangangga\Starsender\Mixin;

use Illuminate\Support\Facades\Http;
use Kangangga\Starsender\Utils\Response;


trait ApiContact
{
    /**
     * Untuk menambah nomor ke dalam kontak dan group
     * @param <name,number,group_id,?group_id> $data
     * @return \Kangangga\Starsender\Utils\Response
     */
    public function addContact(array $data)
    {
        return new Response(
            Http::starsender()
                ->withHeaders([
                    'apiKey' => config('starsender.api_key_profile')
                ])
                ->post('/user/insertContact', $data)
        );
    }

    /**
     * Untuk mengambil semua list group kontak yang ada di akun anda
     * @return \Kangangga\Starsender\Utils\Response
     */
    public function listGroup()
    {
        return new Response(
            Http::starsender()
                ->withHeaders([
                    'apiKey' => config('starsender.api_key_profile')
                ])
                ->post('/getListGroup')
        );
    }

    /**
     * Untuk menghapus nomor yang ada dalam group
     * @param <number,?group_id> $data
     * @return \Kangangga\Starsender\Utils\Response
     */
    public function removeFromGroup(array $data)
    {
        return new Response(
            Http::starsender()
                ->withHeaders([
                    'apiKey' => config('starsender.api_key_profile')
                ])
                ->post('/user/removeFromGroup', $data)
        );
    }

    /**
     * Untuk memindahkan nomor yang ada dalam group ke group lain
     * @param <number,group_id_from,group_id_to> $data
     * @return \Illuminate\Http\Client\Response
     */
    public function changeGroup(array $data)
    {
        $result = Http::starsender()
            ->withHeaders([
                'apiKey' => config('starsender.api_key_profile')
            ])
            ->post('/user/changeGroup', $data);

        return new Response($result);
    }
}
