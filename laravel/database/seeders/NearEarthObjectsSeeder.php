<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\NearEarthObject;

class NearEarthObjectsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        NearEarthObject::factory()->count(10)->make()->each(function ($asteroid) {
            try{
                $asteroid->save();
            }
            catch(\Exception $ex){}

        });
    }
}
