<?php

namespace Tests\Feature\Api\V1;

use App\DataAccess\Eloquent\Article;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    use DatabaseTransactions;

    public function testIndex()
    {
        factory(Article::class, 3)->create();

        $response = $this->getJson('/v1/articles');
        $response->assertStatus(200);
        $response->assertJsonCount(3, 'articles');
        $response->assertJsonStructure(['articles' => [
            [
                'title',
                'description',
                'date',
                'articleUrl',
                'sourceUrl',
                'imageUrl',
                'faviconUrl',
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
