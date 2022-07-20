<?php

namespace Tests\Feature\app\Http\Controllers\NearEarthObjectsController;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;
use App\Models\NearEarthObject;

class hazardousTest extends TestCase
{
    use RefreshDatabase;

    public function test_results_contains_hazardous_object()
    {
        $collection = NearEarthObject::factory()->count(1)->create(['is_hazardous' => 1]);

        $response = $this->get('/neo/hazardous');

        $response->assertStatus(200);

        $results = json_decode($response->getContent());
        $this->assertEquals(1, count($results));

        $this->assertEquals((int)$results[0]->referenced, (int)$collection->first()->referenced);
    }

    public function test_results_contains_only_hazardous_object()
    {
        NearEarthObject::factory()->count(1)->create(['is_hazardous' => 0]);
        $collection = NearEarthObject::factory()->count(1)->create(['is_hazardous' => 1]);
        $object = $collection->first();

        $response = $this->get('/neo/hazardous');

        $response->assertStatus(200);

        $response
            ->assertJson(fn (AssertableJson $json) =>
            $json->has(1)
                ->has('0', fn ($json) =>
                $json->where('referenced', $object->referenced)
                    ->where('is_hazardous', $object->is_hazardous)
                    ->etc()
                )
            );
    }
}
