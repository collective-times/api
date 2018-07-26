<?php

namespace Tests\Feature\Api\V1;

use App\DataAccess\Eloquent\Site;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class SiteTest extends TestCase
{
    use DatabaseTransactions;
    protected $param = [
        'feed_url' => 'https://hoge.jp/atom.xml',
        'source_url' => 'https://hoge.jp/',
        'format' => 'atom',
    ];

    public function testIndex()
    {
        $site = factory(Site::class)->create($this->param);
        $response = $this->getJson('/v1/sites');

        $response->assertStatus(200);
        $response->assertJsonCount(1);
        $response->assertExactJson(['sites' => [
            [
                'id' => $site->id,
                'feedUrl' => $this->param['feed_url'],
                'sourceUrl' => $this->param['source_url'],
                'format' => 'atom',
            ]
        ]]);
    }

    public function testShow()
    {
        $site = factory(Site::class)->create($this->param);
        $response = $this->getJson('/v1/sites/' . $site->id);

        $response->assertStatus(200);
        $response->assertExactJson(['site' => [
            'id' => $site->id,
            'feedUrl' => $this->param['feed_url'],
            'sourceUrl' => $this->param['source_url'],
            'format' => 'atom',
        ]]);
    }

    public function testStore()
    {
        $response = $this->postJson('/v1/sites', $this->param);

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
