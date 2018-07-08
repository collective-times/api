<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use App\DataAccess\Eloquent\Article;
use App\Crawl\RSS2;

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
        $siteUrls  = config('crawl_sites.rss');
        $client = new \GuzzleHttp\Client();

        foreach ($siteUrls as $url) {
            $response = $client->request('GET', $url);
            $crawl = new RSS2();
            $items = $crawl->parse($response->getBody()->getContents());

            foreach ($items as $item) {
                $entity = $crawl->getEntity($item);
                Article::create([
                    'title' => $entity->getTitle(),
                    'description' => $entity->getDescription(),
                    'publish_date' => $entity->getPublishDate(),
                    'article_url' => $entity->getArticleUrl(),
                    'source_url' => 'http://b.hatena.ne.jp/hotentry/it',
                ]);
            }
        }
    }
}
