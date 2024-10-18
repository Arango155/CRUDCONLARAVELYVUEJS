<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class NasaApiController extends Controller
{
    public function getNasaData()
    {
        // Your NASA API key
        $apiKey = env('NASA_API_KEY'); 

        // NASA API URL, this is an example (e.g., for the APOD API)
        $url = "https://api.nasa.gov/planetary/apod?api_key={$apiKey}";

        // Make request using Laravel HTTP client
        $response = Http::get($url);

        // Return the response data
        return $response->json();
    }
}
