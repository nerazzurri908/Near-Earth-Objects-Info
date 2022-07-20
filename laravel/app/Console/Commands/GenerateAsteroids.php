<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\UploadNearEarchObjects;

class GenerateAsteroids extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'asteroids:create  {async=false : Execute command async. By default is sync}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $async = $this->argument('async');

        if ($async == "true") {
            UploadNearEarchObjects::dispatch();
        } else {
            UploadNearEarchObjects::dispatchSync();
        }

        return 0;
    }
}
