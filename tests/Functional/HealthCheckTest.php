<?php

namespace Tests\Functional;

use Tests\TestCase;


class HealthCheckTest extends TestCase
{
    public function testHealthCheck(): void
    {
        $response = $this->get('/api/health-check');

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
    }
}
