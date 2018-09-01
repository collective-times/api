<?php

namespace Tests\Unit\app\DataAccess\Eloquent;

use Tests\TestCase;
use App\DataAccess\Eloquent\Article;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ArticleTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @dataProvider dataProviderForGetShortDescriptionAttribute
     */
    public function testGetShortDescriptionAttribute($description, $expected)
    {
        $article = $this->createArticle($description);

        $this->assertEquals($expected, $article->short_description);
    }

    public function dataProviderForGetShortDescriptionAttribute()
    {
        return [
            ['hoge', 'hoge'],
            ['<b>hoge</b>', 'hoge'],
            [str_repeat('あ', 201), str_repeat('あ', 200)],

        ];
    }

    protected function createArticle($description)
    {
        return Article::create([
            'id' => 1,
            'publish_date' => '2018-01-01 10:00:00',
            'title' => 'hoge',
            'description' => $description,
            'article_url' => 'http://hoge.jp',
            'source_url' => 'http://fuga.jp',
            'image_url' => 'http://age.jp',
            'favicon_url' => 'http://sage.jp',
        ]);
    }
}