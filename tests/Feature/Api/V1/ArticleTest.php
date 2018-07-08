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
}
