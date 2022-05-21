<?php

namespace Kangangga\Starsender\Http\Controllers;

use File;
use Illuminate\Http\Request;
use Storage;

class WebhookController extends Controller
{
    public function index(Request $request)
    {
        $path = 'app/starsender/webhook.json';
        $reqData = $request->all();

        $data = collect([$reqData]);

        if (File::exists(storage_path($path))) {
            $data = collect(json_decode(File::get(storage_path($path))));
            $data->push($reqData);
        }

        Storage::put('starsender/webhook.json', $data->toJson());

        return response()->json([
            'data' => $reqData
        ]);
    }
}
