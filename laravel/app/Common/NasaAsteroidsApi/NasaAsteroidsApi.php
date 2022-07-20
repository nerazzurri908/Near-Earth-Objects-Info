<?php

namespace App\Common\NasaAsteroidsApi;

use Illuminate\Support\Facades\Http;


class NasaAsteroidsApi implements INasaAsteroidsApi
{

    function getClosestToEarthAsteroids($apiKey, $startDate, $endDate): \Illuminate\Http\Client\Response
    {
        if(!$apiKey || !$startDate || !$endDate)
        {
            throw new \Exception('Received invalid params in method getClosestToEarthAsteroids');
        }

        return Http::get('https://api.nasa.gov/neo/rest/v1/feed', [
            'start_date' => $startDate,
            'end_date' => $endDate,
            'api_key' => $apiKey,
        ]);
    }

}
