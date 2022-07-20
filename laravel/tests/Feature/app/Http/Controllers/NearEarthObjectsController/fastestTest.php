<?php

namespace Tests\Feature\app\Http\Controllers\NearEarthObjectsController;

use App\Models\NearEarthObject;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Database\Seeders\NearEarthObjectsSeeder;
use Tests\TestCase;

class fastestTest extends TestCase
{
    //use DatabaseMigrations;
    use RefreshDatabase;

    /**
     * This method is called before
     * any test of TestCase class executed
     * @return void
     */
    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        //shell_exec('php artisan db:seed --class=NearEarthObjectsSeeder');
    }


    /**
     * This method is called after
     * all tests of TestCase class executed
     * @return void
     */
    public static function tearDownAfterClass(): void
    {
        parent::tearDownAfterClass();
    }

    public function setUp(): void
    {
        parent::setUp();

        $this->seed(NearEarthObjectsSeeder::class);
    }

    public function tearDown(): void
    {
        parent::tearDown();
    }

    public function test_results_ordered_descending_by_speed()
    {
        $response = $this->get('/neo/fastest');

        $response->assertStatus(200);

        $results = json_decode($response->getContent());

	    $this->assertTrue($this->collection_ordered_descending_by_speed($results));
    }

    public function test_results_without_hazardous_objects()
    {
        $response = $this->get('/neo/fastest');

        $results = json_decode($response->getContent());

        foreach ($results as $item)
        {
            if ($item->is_hazardous)
            {
                $this->throwException(new \Exception('Collection contains item with property "is_hazardous" equal true'));
            }
        }

        $this->assertTrue(true);
    }

    public function test_argument_hazardous_as_true_filter_results_by_hazardous_objects()
    {
        $response = $this->get('/neo/fastest?hazardous=true');

        $response->assertStatus(200);

        $results = json_decode($response->getContent());

        $this->assertTrue($this->collection_contains_only_hazardous_objects($results));

	    $this->assertTrue($this->collection_ordered_descending_by_speed($results));
    }

    public function test_argument_hazardous_as_false_not_filter_results_by_hazardous_objects()
    {
        $response = $this->get('/neo/fastest?hazardous=false');
        $response->assertStatus(200);
        $results = json_decode($response->getContent());

        $response2 = $this->get('/neo/fastest');
        $response->assertStatus(200);
        $results2 = json_decode($response2->getContent());

        $this->assertEquals($results, $results2);
    }


    private function collection_ordered_descending_by_speed($collection)
    {
        $max = $collection[0]->speed;
        foreach ($collection as $item)
        {
            if ($item->speed > $max)
            {
		        return false;
            }
            $max = $item->speed;
        }

	    return true;
    }


    private function collection_contains_only_hazardous_objects($collection)
    {
        foreach ($collection as $item)
        {
            if (!$item->is_hazardous)
            {
                return false;
            }
        }

	    return true;
    }

}
