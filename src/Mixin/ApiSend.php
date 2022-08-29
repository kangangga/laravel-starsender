<?php

namespace Kangangga\Starsender\Mixin;

use File;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Kangangga\Starsender\Utils\Parser;
use Kangangga\Starsender\Utils\Response;

trait ApiSend
{
    /**
     * untuk mengirim pesan yang isinya hanya Text
     *
     * @param <phone,message,?group_name,?timetable> $data
     * @return \Kangangga\Starsender\Utils\Response
     */
    public function sendText(array $data)
    {
        $endpoint = $this->isNewVersion($data) ? '/v2/sendText' : '/sendText';

        return new Response(
            Http::starsender()
                ->post($endpoint, Parser::parseData($data))
        );
    }

    /**
     * untuk mengirim pesan button yang berisi button dengan file gambar
     *
     * @param <phone,message,buttons[],?footer,?file> $params
     * @return \Kangangga\Starsender\Utils\Response
     */
    public function sendButton(array $params)
    {
        $data = Parser::parseData($params, [
            'button' => Parser::button($params),
        ]);

        $request =  Http::starsender();

        if (array_key_exists('file', $params)) {
            $contents = File::get($params['file']);
            $file_name = $params['file_name'] ?? File::basename($params['file']);
            $request->attach('file', $contents, $file_name);
        }

        return new Response($request->post('/sendButton', $data));
    }

    /**
     * untuk mengirim pesan yang berisi url file atau gambar
     *
     * @param <phone,message,file,?group_name> $data
     * @return \Kangangga\Starsender\Utils\Response
     */
    public function sendFiles(array $data)
    {
        return $this->sendFilesUrl($data);
    }

    /**
     * untuk mengirim pesan yang berisi url file atau gambar
     *
     * @param <phone,message,file,?group_name> $data
     * @return \Kangangga\Starsender\Utils\Response
     */
    public function sendFilesUrl(array $data)
    {
        $endpoint = $this->isNewVersion($data) ? '/v2/sendFiles' : '/sendFiles';

        return new Response(
            Http::starsender()
                ->post($endpoint, Parser::parseData($data, [
                    'file' => $data['file']
                ]))
        );
    }

    /**
     * untuk mengirim pesan yang berisi content file atau gambar
     *
     * @param <phone,message,file,?group_name> $data
     * @return \Kangangga\Starsender\Utils\Response
     */
    public function sendFilesUpload(array $data)
    {
        $contents = File::get($data['file']);
        $file_name = $data['file_name'] ?? File::basename($data['file']);

        $endpoint = $this->isNewVersion($data) ? '/v2/sendFilesUpload' : '/sendFilesUpload';


        return new Response(
            Http::starsender()
                ->attach('file', $contents, $file_name)
                ->post($endpoint, Parser::parseData($data))
        );
    }
}
