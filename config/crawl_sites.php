<?php

/**
 * crawl_url string クロールするURL
 * source_url string ソース元URL
 * enabled boolean クロール対象フラグ
 * class string 処理クラス
 */
return [
    [
        'title' => 'はてなブックマーク テクノロジー 人気エントリー',
        'crawl_url' => 'http://b.hatena.ne.jp/hotentry/it.rss',
        'source_url' => 'http://b.hatena.ne.jp/hotentry/it',
        'enabled' => true,
        'class' => '\App\ContentsParser\Entity\Hatena',
    ],
    [
        'title' => 'はてなブックマーク テクノロジー 新着エントリー',
        'crawl_url' => 'http://b.hatena.ne.jp/entrylist/it.rss',
        'source_url' => 'http://b.hatena.ne.jp/entrylist/it',
        'enabled' => true,
        'class' => '\App\ContentsParser\Entity\Hatena',
    ],
    [
        'title' => 'Amazon Web Services ブログ',
        'crawl_url' => 'https://aws.amazon.com/jp/blogs/news/feed/',
        'source_url' => 'https://aws.amazon.com/jp/blogs/news/',
        'enabled' => true,
        'class' => '\App\ContentsParser\Entity\RSS2',
    ],
    [
        'title' => 'Google Cloud Platform Japan Blog',
        'crawl_url' => 'http://feeds.feedburner.com/GoogleCloudPlatformJapanBlog',
        'source_url' => 'https://cloudplatform-jp.googleblog.com/',
        'enabled' => true,
        'class' => '\App\ContentsParser\Entity\RSS2',
    ],
    [
        'title' => 'Mercari Engineering Blog',
        'crawl_url' => 'https://tech.mercari.com/rss',
        'source_url' => 'https://tech.mercari.com/',
        'enabled' => true,
        'class' => '\App\ContentsParser\Entity\RSS2',
    ],
];
