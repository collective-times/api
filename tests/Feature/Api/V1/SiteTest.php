<?php

namespace Tests\Feature\Api\V1;

use App\DataAccess\Eloquent\Article;
use App\DataAccess\Eloquent\Site;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Laravel\Passport\Passport;
use App\DataAccess\Eloquent\User;
use Tests\TestCase;

class SiteTest extends TestCase
{
    use DatabaseTransactions;
    protected $param = [
        'title' => 'hoge',
        'feed_url' => 'https://hoge.jp/atom.xml',
        'source_url' => 'https://hoge.jp/',
        'crawlable' => true,
        'type' => 'rss',
    ];

    public function setUp(): void
    {
        parent::setUp();

        $user = factory(User::class)->create();
        Passport::actingAs($user);
    }

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
                'type' => 'rss',
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
            'type' => 'rss',
        ]]);
    }

    public function testShow_WillResponseValidationError_WhenGivenLessParameters()
    {
        $response = $this->getJson('/v1/sites/9999');

        $response->assertStatus(404);
    }

    public function testStore()
    {
        $created = [
            'title' => $this->param['title'],
            'feedUrl' => $this->param['feed_url'],
            'sourceUrl' => $this->param['source_url'],
            'crawlable' => $this->param['crawlable'],
            'type' => $this->param['type'],
        ];
        $response = $this->postJson('/v1/sites', $created);

        $response->assertStatus(201);
        $response->assertExactJson(array_merge(['id'=> $response->json('id')], $created));
    }

    public function testStore_WillResponseValidationError_WhenTryToRegisterDupulicatedData()
    {
        factory(Site::class)->create($this->param);

        $created = [
            'title' => $this->param['title'],
            'feedUrl' => $this->param['feed_url'],
            'sourceUrl' => $this->param['source_url'],
            'crawlable' => $this->param['crawlable'],
            'type' => $this->param['type'],
        ];
        $response = $this->postJson('/v1/sites', $created);

        $response->assertStatus(422);

        $this->assertEquals('The given data was invalid.', $response->json('message'));
        $this->assertEquals('The feed url has already been taken.', $response->json('errors.feedUrl.0'));
        $this->assertEquals('The source url has already been taken.', $response->json('errors.sourceUrl.0'));

        $response->assertJsonStructure([
            'message',
            'errors'
        ]);
    }

    public function testStore_WillResponseValidationError_WhenGivenLessParameters()
    {
         $created = [
            'feedUrl' => $this->param['feed_url'],
            'sourceUrl' => $this->param['source_url'],
            'crawlable' => $this->param['crawlable'],
            'type' => $this->param['type'],
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
            'type' => $this->param['type'],
        ];
        $response = $this->putJson('/v1/sites/' . $site->id, $updated);

        $response->assertStatus(200);
        $response->assertExactJson(array_merge(['id'=> $site->id], $updated));
    }

    public function testUpdate_WillResponse404_WhenSpecifiedNotExceptingId()
    {
        $response = $this->putJson('/v1/sites/9999');

        $response->assertStatus(404);
    }

    public function testDelete()
    {
        $site = factory(Site::class)->create(['type' => 'rss']);
        $response = $this->deleteJson('/v1/sites/' . $site->id);
        $response->assertStatus(204);
        $this->assertDatabaseMissing('sites', [
            'id' => $site->id
        ]);
    }

    public function testDelete_WillDeleteWithArticles_WhenDeleteSite()
    {
        $site = factory(Site::class)->create(['type' => 'rss']);
        factory(Article::class, 3)->create([
            'site_id' => $site->id
        ]);
        $response = $this->deleteJson('/v1/sites/' . $site->id);
        $response->assertStatus(204);
        $this->assertDatabaseMissing('sites', [
            'id' => $site->id
        ]);
    }

    public function testDelete_WillResponse404_WhenSpecifiedNotExceptingId()
    {
        $response = $this->deleteJson('/v1/sites/9999');

        $response->assertStatus(404);
    }
}
