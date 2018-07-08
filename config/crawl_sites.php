<?php

return [
    [
        'crawl_url' => 'http://b.hatena.ne.jp/hotentry/it.rss',
        'source_url' => 'http://b.hatena.ne.jp/hotentry/it',
        'enabled' => true, // true: クロール対象とする false: クロール対象外とする
        'class' => '\App\ContentsParser\RSS2',
    ],
];
