<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\DataAccess\Eloquent\Article;

class Crawl extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crawl:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run crawling';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $sites = config('crawl_sites');
        $client = new \GuzzleHttp\Client(['headers' => ['User-Agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.99 Safari/537.36']]);

        foreach ($sites as $site) {
            if (!$site['enabled']) {
                continue;
            }

            $response = $client->request('GET', $site['crawl_url']);
            $crawl = new $site['class']();
            $items = $crawl->parse($response->getBody()->getContents());

            foreach ($items as $item) {
                $entity = $crawl->getEntity($item);

                // 記事URLが登録済みの場合はスキップする
                $article = Article::where('article_url', $entity->getArticleUrl())->first();
                if ($article) {
                    continue;
                }

                Article::create([
                    'title' => $entity->getTitle(),
                    'description' => $entity->getDescription(),
                    'publish_date' => $entity->getPublishDate(),
                    'article_url' => $entity->getArticleUrl(),
                    'source_url' => $site['source_url'],
                    'image_url' => $entity->getImageUrl(),
                    'favicon_url' => $entity->getFaviconUrl(),
                ]);
            }
        }
    }
}
