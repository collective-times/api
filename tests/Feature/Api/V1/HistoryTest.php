<?php

namespace Tests\Feature\Api\V1;

use App\DataAccess\Eloquent\Article;
use App\DataAccess\Eloquent\ArticleUser;
use App\DataAccess\Eloquent\Site;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Laravel\Passport\Passport;
use App\DataAccess\Eloquent\User;
use Tests\TestCase;

class HistoryTest extends TestCase
{
    use DatabaseTransactions;
    protected $user;
    protected $site;
    protected $articleParam;
    protected $article;

    public function setUp()
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
        $this->site = factory(Site::class)->create();
        $this->articleParam = [
            'id' => 1,
            'site_id' => $this->site->id,
            'publish_date' => '2018-01-01 10:00:00',
            'title' => 'hoge',
            'description' => 'fuga',
            'article_url' => 'http://hoge.jp',
            'source_url' => 'http://fuga.jp',
            'image_url' => 'http://age.jp',
            'favicon_url' => 'http://sage.jp',
        ];
        $this->article = factory(Article::class)->create($this->articleParam);

        Passport::actingAs($this->user);
    }

    public function testIndex()
    {
        $this->user->articles()->save($this->article);

        $response = $this->getJson('/v1/histories');

        $response->assertStatus(200);
        $response->assertExactJson(['histories' => [
            [
                'article' => [
                    'key' => $this->articleParam['id'],
                    'date' => $this->articleParam['publish_date'],
                    'title' => $this->articleParam['title'],
                    'description' => $this->articleParam['description'],
                    'articleUrl' => $this->articleParam['article_url'],
                    'sourceTitle' => $this->site->title,
                    'sourceUrl' => $this->articleParam['source_url'],
                    'imageUrl' => $this->articleParam['image_url'],
                    'faviconUrl' => $this->articleParam['favicon_url'],
                ],
                'user' => [
                    'name' => $this->user->name
                ]
            ]
        ]]);
    }

    public function testStore()
    {
        $created = [
            'article_id' => $this->article->id,
        ];
        $response = $this->postJson('/v1/histories', $created);

        $response->assertStatus(201);
        $response->assertExactJson($created);
        $this->assertDatabaseHas('article_user', [
            'user_id' => $this->user->id,
            'article_id' => $this->article->id,
        ]);
    }

    public function testDestroy()
    {
        $this->user->articles()->save($this->article);

        $response = $this->deleteJson('/v1/histories/' . $this->article->id);

        $response->assertStatus(204);
        $this->assertDatabaseMissing('article_user', [
            'user_id' => $this->user->id,
            'article_id' => $this->article->id,
        ]);
    }
}
