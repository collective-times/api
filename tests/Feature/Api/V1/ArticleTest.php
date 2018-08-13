<?php

namespace Tests\Feature\Api\V1;

use App\DataAccess\Eloquent\Article;
use App\DataAccess\Eloquent\Site;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    use DatabaseTransactions;

    public function testIndex()
    {
        $site = factory(Site::class)->create();
        $params = [
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
        factory(Article::class, 1)->create($params);

        $response = $this->getJson('/v1/articles');
        $response->assertStatus(200);
        $response->assertJsonCount(1, 'articles');
        $response->assertExactJson(['articles' => [
            [
                'key' => $params['id'],
                'date' => $params['publish_date'],
                'title' => $params['title'],
                'description' => $params['description'],
                'articleUrl' => $params['article_url'],
                'sourceTitle' => $site->title,
                'sourceUrl' => $params['source_url'],
                'imageUrl' => $params['image_url'],
                'faviconUrl' => $params['favicon_url'],
            ]
        ]]);
    }

    public function textIndex_WillResponse10Items_WhenPage1()
    {
        factory(Article::class, 15)->create();

        $response = $this->getJson('/v1/articles?page=1');
        $response->assertStatus(200);
        $response->assertJsonCount(10, 'articles');
    }

    public function textIndex_WillResponse5Items_WhenPage2()
    {
        factory(Article::class, 15)->create();

        $response = $this->getJson('/v1/articles?page=2');
        $response->assertStatus(200);
        $response->assertJsonCount(5, 'articles');
    }

    public function textIndex_WillResponseZeroItems_WhenPage3()
    {
        factory(Article::class, 15)->create();

        $response = $this->getJson('/v1/articles?page=2');
        $response->assertStatus(200);
        $response->assertJsonCount(5, 'articles');
    }
}
