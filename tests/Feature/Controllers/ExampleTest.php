<?php

namespace Tests\Feature\Controllers;

use Tests\TestCase;

class WeatherController extends TestCase
{
    /**
     * Test index view.
     *
     * @return void
     */
    public function testIndex()
    {
        $response = $this->get(route('index'));

        $response->assertStatus(200);
    }
}
