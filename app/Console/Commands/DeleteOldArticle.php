<?php

/**
 * 古い記事データを削除する
 */

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DeleteOldArticle extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete_old_article:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete old articles.';

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
     * @return int
     */
    public function handle()
    {
        // 一ヶ月前より以前に登録されかつ閲覧履歴が無い記事データ一覧を取得
        $articles = DB::table('articles')
            ->where('publish_date', '<=', Carbon::now()->subMonth())
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('article_user')
                    ->whereRaw('article_user.article_id = articles.id');
            });

        // 対象レコードを削除する
        $articles->delete();
    }
}
