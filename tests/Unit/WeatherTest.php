<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class WeatherTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testWeatherTest()
    {        
        
        $response = $this->get('/weather/London,USA');

        $response->assertStatus(200);
    }
}
