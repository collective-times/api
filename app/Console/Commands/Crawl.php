<?php

namespace App\Console\Commands;

use App\ContentsParser\Request;
use Illuminate\Console\Command;
use App\DataAccess\Eloquent\Article;
use App\DataAccess\Eloquent\Site;

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
        $sites = Site::where('crawlable', true)->get();

        foreach ($sites as $site) {
            $request = new Request();
            $items = $request->request($site->source_url);

            foreach ($items as $item) {
                $parser = collect(config('contentsparser'))->firstWhere('type', $site->type);
                $entity = new $parser['class']($item);

                // 記事URLが登録済みの場合はスキップする
                $article = Article::where('article_url', $entity->getArticleUrl())->first();
                if ($article) {
                    continue;
                }

                Article::create([
                    'site_id' => $site->id,
                    'title' => $entity->getTitle(),
                    'description' => mb_substr($entity->getDescription(), 0, 1000),
                    'publish_date' => $entity->getPublishDate(),
                    'article_url' => $entity->getArticleUrl(),
                    'source_url' => $site->source_url,
                    'image_url' => $entity->getImageUrl(),
                    'favicon_url' => $entity->getFaviconUrl(),
                ]);
            }
        }
    }
}
