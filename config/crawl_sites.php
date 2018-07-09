<?php

return [
    [
        'crawl_url' => 'http://b.hatena.ne.jp/hotentry/it.rss',
        'source_url' => 'http://b.hatena.ne.jp/hotentry/it',
        'enabled' => true, // true: クロール対象とする false: クロール対象外とする
        'mode' => 'guzzle',
        'class' => '\App\ContentsParser\RSS2',
    ],
    [
        'crawl_url' => 'http://b.hatena.ne.jp/entrylist/it.rss',
        'source_url' => 'http://b.hatena.ne.jp/entrylist/it',
        'enabled' => true, // true: クロール対象とする false: クロール対象外とする
        'mode' => 'guzzle',
        'class' => '\App\ContentsParser\RSS2',
    ],
    [
        'crawl_url' => 'https://aws.amazon.com/jp/blogs/news/feed/',
        'source_url' => 'https://aws.amazon.com/jp/blogs/news/',
        'enabled' => true, // true: クロール対象とする false: クロール対象外とする
        'mode' => 'file_get_contents',
        'class' => '\App\ContentsParser\AwsBlog',
    ],
];
