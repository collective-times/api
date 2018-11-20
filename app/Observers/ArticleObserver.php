<?php

namespace App\Observers;

use App\DataAccess\Eloquent\Article;
use App\Notifications\Slack;
use App\Notifications\SlackNotifiable;

class ArticleObserver
{
    /**
     * Handle the article "created" event.
     *
     * @param  Article  $article
     * @return void
     */
    public function created(Article $article)
    {
        if (config('APP_ENV') == 'production') {
            sleep(10); // URL展開を待つため

            (new SlackNotifiable())->notify(new Slack(
                $article->article_url
            ));
        }
    }
}
