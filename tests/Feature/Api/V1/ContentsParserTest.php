<?php

namespace Tests\Feature\Api\V1;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ContentsParserTest extends TestCase
{
    use DatabaseTransactions;

    public function testIndex()
    {
        $response = $this->getJson('/v1/contents-parsers');

        $response->assertStatus(200);
        $response->assertJsonStructure(['contents-parsers' => [
            ['type', 'class']
        ]]);
    }
}
