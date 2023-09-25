<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
   
    public function testBasicTest(): void
    {
        $response = $this->get('/nosotros');

        $response->assertStatus(200);
    }
}
