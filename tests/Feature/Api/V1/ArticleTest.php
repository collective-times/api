<?php

namespace Tests\Feature\Api\V1;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ArticleTest extends TestCase
{
    public function testIndex()
    {
        $response = $this->getJson('/v1/articles');

        $response->assertStatus(200);
    }
}
