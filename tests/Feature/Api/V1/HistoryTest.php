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

    public function setUp()
    {
        parent::setUp();

        $this->user = factory(User::class)
            ->create();
        Passport::actingAs($this->user);
    }

    public function testIndex()
    {
        $site = factory(Site::class)->create();
        $article = [
            'id' => 1,
            'site_id' => $site->id,
            'publish_date' => '2018-01-01 10:00:00',
            'title' => 'hoge',
            'description' => 'fuga',
            'article_url' => 'http://hoge.jp',
            'source_url' => 'http://fuga.jp',
            'image_url' => 'http://age.jp',
            'favicon_url' => 'http://sage.jp',
        ];
        $article = factory(Article::class)->create($article);
        $this->user->articles()->save($article);

        $response = $this->getJson('/v1/histories');

        $response->assertStatus(200);
        $response->assertExactJson(['histories' => [
            [
                'article' => [
                    'key' => $article['id'],
                    'date' => $article['publish_date'],
                    'title' => $article['title'],
                    'description' => $article['description'],
                    'articleUrl' => $article['article_url'],
                    'sourceTitle' => $site->title,
                    'sourceUrl' => $article['source_url'],
                    'imageUrl' => $article['image_url'],
                    'faviconUrl' => $article['favicon_url'],
                ],
                'user' => [
                    'name' => $this->user->name
                ]
            ]
        ]]);
    }

    public function testStore()
    {
        $site = factory(Site::class)->create();
        $article = [
            'id' => 1,
            'site_id' => $site->id,
            'publish_date' => '2018-01-01 10:00:00',
            'title' => 'hoge',
            'description' => 'fuga',
            'article_url' => 'http://hoge.jp',
            'source_url' => 'http://fuga.jp',
            'image_url' => 'http://age.jp',
            'favicon_url' => 'http://sage.jp',
        ];
        $article = factory(Article::class)->create($article);

        $created = [
            'article_id' => $article->id,
        ];
        $response = $this->postJson('/v1/histories', $created);

        $response->assertStatus(201);
        $response->assertExactJson($created);
        $this->assertDatabaseHas('article_user', [
            'user_id' => $this->user->id,
            'article_id' => $article->id,
        ]);
    }
}
