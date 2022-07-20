<?php

namespace App\Common\NasaAsteroidsApi;

interface INasaAsteroidsApi{

    function getClosestToEarthAsteroids($apiKey, $startDate, $endDate);

}
