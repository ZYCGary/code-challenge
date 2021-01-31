<?php

namespace App\Http\Controllers\Api;

use GuzzleHttp\Client;
use Exception;
use Http;
use Illuminate\Http\Request;

class CarController extends Controller
{
    public function index()
    {
        try {
            $url = "https://www.imintheright.com.au/devtest/get-vehicle-make-list.php";

            $response = Http::get($url);

            $cars = json_decode($response->body());

            return response()->json($cars);
        } catch (Exception $exception) {
            return response(500);
        }

    }
}
