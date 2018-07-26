<?php

namespace Tests\Feature\Api\V1;

use App\DataAccess\Eloquent\Site;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class SiteTest extends TestCase
{
    use DatabaseTransactions;

    public function testIndex()
    {
        $response = $this->getJson('/v1/sites');

        $response->assertStatus(200);
    }

    public function testShow()
    {
        $site = factory(Site::class)->create(['format' => 'atom']);
        $response = $this->getJson('/v1/sites/' . $site->id);

        $response->assertStatus(200);
    }

    public function testStore()
    {
        $response = $this->postJson('/v1/sites', []);

        $response->assertStatus(201);
    }

    public function testUpdate()
    {
        $site = factory(Site::class)->create(['format' => 'atom']);
        $response = $this->putJson('/v1/sites/' . $site->id);

        $response->assertStatus(200);
    }

    public function testDelete()
    {
        $site = factory(Site::class)->create(['format' => 'atom']);
        $response = $this->deleteJson('/v1/sites/' . $site->id);

        $response->assertStatus(204);
    }
}
