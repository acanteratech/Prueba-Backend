<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ApiTest extends TestCase
{
    public function test_short_urls()
    {
        $response = $this->post(route('short-urls'), ["url" => 'http://www.example.com']);

        $response->assertStatus(200);
    }
}
