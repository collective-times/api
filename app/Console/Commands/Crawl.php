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
        $client = new \GuzzleHttp\Client();

        foreach ($sites as $site) {
            if (!$site['enabled']) {
                continue;
            }

            $response = $client->request('GET', $site['crawl_url']);
            $crawl = new $site['class']();
            $items = $crawl->parse($response->getBody()->getContents());

            foreach ($items as $item) {
                $entity = $crawl->getEntity($item);
                Article::create([
                    'title' => $entity->getTitle(),
                    'description' => $entity->getDescription(),
                    'publish_date' => $entity->getPublishDate(),
                    'article_url' => $entity->getArticleUrl(),
                    'source_url' => $site['source_url'],
                ]);
            }
        }
    }
}
