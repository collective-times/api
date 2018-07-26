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
        $created = [
            'feedUrl' => $this->param['feed_url'],
            'sourceUrl' => $this->param['source_url'],
            'format' => $this->param['format'],
        ];
        $response = $this->postJson('/v1/sites', $created);

        $response->assertStatus(201);
        $response->assertExactJson(array_merge(['id'=> $response->json('id')], $created));
    }

    public function testUpdate()
    {
        $site = factory(Site::class)->create([]);
        $updated = [
            'feedUrl' => $this->param['feed_url'],
            'sourceUrl' => $this->param['source_url'],
            'format' => $this->param['format'],
        ];
        $response = $this->putJson('/v1/sites/' . $site->id, $updated);

        $response->assertStatus(200);
        $response->assertExactJson(array_merge(['id'=> $site->id], $updated));
    }

    public function testDelete()
    {
        $site = factory(Site::class)->create(['format' => 'atom']);
        $response = $this->deleteJson('/v1/sites/' . $site->id);

        $response->assertStatus(204);
        $this->assertDatabaseMissing('sites', [
            'id' => $site->id
        ]);
    }
}
