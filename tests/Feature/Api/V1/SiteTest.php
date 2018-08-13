<?php

namespace Tests\Feature\Api\V1;

use App\DataAccess\Eloquent\Site;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class SiteTest extends TestCase
{
    use DatabaseTransactions;
    protected $param = [
        'title' => 'hoge',
        'feed_url' => 'https://hoge.jp/atom.xml',
        'source_url' => 'https://hoge.jp/',
        'crawlable' => true,
        'class' => '\App\ContentsParser\Entity\RSS',
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
                'title' => $site->title,
                'feedUrl' => $this->param['feed_url'],
                'sourceUrl' => $this->param['source_url'],
                'crawlable' => true,
                'class' => '\App\ContentsParser\Entity\RSS',
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
            'title' => $site->title,
            'feedUrl' => $this->param['feed_url'],
            'sourceUrl' => $this->param['source_url'],
            'crawlable' => true,
            'class' => '\App\ContentsParser\Entity\RSS',
        ]]);
    }

    public function testStore()
    {
        $created = [
            'title' => $this->param['title'],
            'feedUrl' => $this->param['feed_url'],
            'sourceUrl' => $this->param['source_url'],
            'crawlable' => $this->param['crawlable'],
            'class' => $this->param['class'],
        ];
        $response = $this->postJson('/v1/sites', $created);

        $response->assertStatus(201);
        $response->assertExactJson(array_merge(['id'=> $response->json('id')], $created));
    }

    public function testStore_WillResponseValidationError_WhenGivenLessParameters()
    {
         $created = [
            'feedUrl' => $this->param['feed_url'],
            'sourceUrl' => $this->param['source_url'],
            'crawlable' => $this->param['crawlable'],
            'class' => $this->param['class'],
        ];
        $response = $this->postJson('/v1/sites', $created);

        $response->assertStatus(422);
        $this->assertEquals('The given data was invalid.', $response->json('message'));
        $this->assertEquals('The title field is required.', $response->json('errors.title.0'));
        $response->assertJsonStructure([
            'message',
            'errors'
        ]);
    }

    public function testUpdate()
    {
        $site = factory(Site::class)->create([]);
        $updated = [
            'title' => $this->param['title'],
            'feedUrl' => $this->param['feed_url'],
            'sourceUrl' => $this->param['source_url'],
            'crawlable' => $this->param['crawlable'],
            'class' => $this->param['class'],
        ];
        $response = $this->putJson('/v1/sites/' . $site->id, $updated);

        $response->assertStatus(200);
        $response->assertExactJson(array_merge(['id'=> $site->id], $updated));
    }

    public function testDelete()
    {
        $site = factory(Site::class)->create(['class' => '\App\ContentsParser\Entity\RSS']);
        $response = $this->deleteJson('/v1/sites/' . $site->id);

        $response->assertStatus(204);
        $this->assertDatabaseMissing('sites', [
            'id' => $site->id
        ]);
    }
}
