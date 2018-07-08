<?php

namespace App\Console\Commands;

use Carbon\Carbon;
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
        $siteUrls  = config('crawl_sites.rss');
        $client = new \GuzzleHttp\Client();

        foreach ($siteUrls as $url) {
            $response = $client->request('GET', $url);
            $rss = simplexml_load_string($response->getBody()->getContents());
            $nameSpaces = $rss->getNamespaces(true);
            foreach ($rss->item as $item) {
                $nameSpacedItem = $item->children($nameSpaces['dc']);
                $date = new Carbon($nameSpacedItem->date);
                Article::create([
                    'title' => $item->title,
                    'description' => $item->description,
                    'publish_date' => $date->toDateTimeString(),
                    'article_url' => $item->link,
                    'source_url' => 'http://b.hatena.ne.jp/hotentry/it',
                ]);
            }
        }
    }
}
