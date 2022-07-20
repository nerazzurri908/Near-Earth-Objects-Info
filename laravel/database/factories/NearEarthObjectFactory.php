<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;
use Carbon\Carbon;

class NearEarthObjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $id = $this->faker->unique()->randomDigit;

        return [
            'referenced' => $id,
            'name' => $id,
            'speed' => $this->faker->randomFloat(10, 100, 100000),
            'is_hazardous' => rand(0, 1),
            'Date' => Carbon::now()->subDays(rand(1, 55))->isoFormat('YYYY-MM-DD'),
        ];
    }
}
