<?php

namespace Tests\Feature\app\Jobs;

use App\Common\NasaAsteroidsApi\INasaAsteroidsApi;
use Mockery\MockInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Jobs\UploadNearEarchObjects;
use Tests\TestCase;

class UploadNearEarchObjectsTest extends TestCase
{

    use RefreshDatabase;

    private  static $jobObject;

    /**
     * This method is called before
     * any test of TestCase class executed
     * @return void
     */
    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        self::$jobObject = new UploadNearEarchObjects();
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

        print "\nsetUp\n";

    }

    public function test_job_handled_successfully()
    {
        $json = $this->getSuccessApiResponse();

        $mockObject = $this->mock(INasaAsteroidsApi::class, function (MockInterface $mock) use($json) {
            $mock->shouldReceive('getClosestToEarthAsteroids')->once()
            ->andReturn($json);
        });

        self::$jobObject->handle($mockObject);

        $this->assertDatabaseCount('near_earth_objects',1);
    }

    public function test_when_api_response_is_empty_no_records_added_to_db()
    {
        $mockObject = $this->mock(INasaAsteroidsApi::class, function (MockInterface $mock) {
            $mock->shouldReceive('getClosestToEarthAsteroids')->once()
                ->andReturn('');
        });

        self::$jobObject->handle($mockObject);

        $this->assertDatabaseCount('near_earth_objects',0);
    }

    public function test_when_response_not_contains_items_no_records_added_to_db()
    {
        $mockObject = $this->mock(INasaAsteroidsApi::class, function (MockInterface $mock) {
            $mock->shouldReceive('getClosestToEarthAsteroids')->once()
                ->andReturn('{"element_count": 0, }');

        });

        self::$jobObject->handle($mockObject);

        $this->assertDatabaseCount('near_earth_objects',0);
    }
    public function test_when_field_near_earth_objects_is_empty_no_records_added_to_db()
    {
        $mockObject = $this->mock(INasaAsteroidsApi::class, function (MockInterface $mock) {
            $mock->shouldReceive('getClosestToEarthAsteroids')->once()
                ->andReturn('{"element_count": 0, "near_earth_objects": {} }');
        });

        self::$jobObject->handle($mockObject);

        $this->assertDatabaseCount('near_earth_objects',0);
    }

    public function getSuccessApiResponse()
    {
        return '
            {
                "element_count": 1,
                "near_earth_objects":{
                    "2015-09-08":
                    [
                        {
                            "id": "2440012",
                            "neo_reference_id": "2440012",
                            "name": "440012 (2002 LE27)",
                            "is_potentially_hazardous_asteroid": false,
                            "close_approach_data": [
                                {
                                    "close_approach_date": "2015-09-07",
                                    "close_approach_date_full": "2015-Sep-07 07:32",
                                    "epoch_date_close_approach": 1441611120000,
                                    "relative_velocity": {
                                        "kilometers_per_second": "1.1630843052",
                                        "kilometers_per_hour": "4187.1034988155",
                                        "miles_per_hour": "2601.7032823612"
                                    },
                                    "miss_distance": {
                                        "astronomical": "0.4981690972",
                                        "lunar": "193.7877788108",
                                        "kilometers": "74525035.840942964",
                                        "miles": "46307709.9545183432"
                                    },
                                    "orbiting_body": "Earth"
                                }
                            ]
                        }
                    ]
                }
            }';
    }
}
