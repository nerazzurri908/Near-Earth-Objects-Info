<?php

namespace Tests\Feature\app\Console\Commands;

use App\Jobs\UploadNearEarchObjects;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Bus;

class GenerateAsteroidsTest extends TestCase
{

    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function test_flag_async_dispatch_job_asynchron()
    {
        Bus::fake();

        $this->artisan('asteroids:create async')->assertSuccessful();

        Bus::assertDispatched(UploadNearEarchObjects::class);
    }

    public function test_run_command_without_flag_async_dispatch_job_syncrhonus()
    {
        Bus::fake();

        $this->artisan('asteroids:create')->assertSuccessful();

        Bus::assertDispatchedSync(UploadNearEarchObjects::class);
    }
}
