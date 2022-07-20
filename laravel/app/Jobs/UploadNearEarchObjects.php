<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Common\NasaAsteroidsApi\INasaAsteroidsApi;
use App\Models\NearEarthObject;
use Carbon\Carbon;

class UploadNearEarchObjects implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }


    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(INasaAsteroidsApi $asteroidsApi)
    {
        $api_key = $this->getApiKey();

        $startDate = Carbon::now()->subDays(3)->isoFormat('YYYY-MM-DD');
        $endDate = Carbon::now()->isoFormat('YYYY-MM-DD');

        $data = $asteroidsApi->getClosestToEarthAsteroids($api_key, $startDate, $endDate);
        $data = json_decode($data);

        if (!$data || !$data->element_count)
        {
            return;
        }

        foreach ($data->near_earth_objects as $key => $asteroids)
        {
            if(!is_array($asteroids)){continue;}

            foreach ($asteroids as $asteroid)
            {
                NearEarthObject::create([
                    'referenced' => $asteroid->neo_reference_id,
                    'name' => $asteroid->name,
                    'speed' => $asteroid->close_approach_data[0]->relative_velocity->kilometers_per_hour,
                    'is_hazardous' => $asteroid->is_potentially_hazardous_asteroid,
                    'Date' => $asteroid->close_approach_data[0]->close_approach_date
                ]);
            }
        }
    }

    public function getApiKey()
    {
        return env('NASA_ASTEROIDS_API_KEY');
    }
}
