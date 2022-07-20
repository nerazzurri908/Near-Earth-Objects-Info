<?php

namespace Tests\Feature\app\Http\Controllers;

use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class DefaultControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_invoke()
    {
        $response = $this->get('/');

        $response->assertStatus(200);

        $response->assertJson(fn (AssertableJson $json) =>
            $json->where('hello', 'MacPaw Internship 2022!')
        );
    }
}
