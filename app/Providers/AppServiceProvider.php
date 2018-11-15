<?php

namespace App\Providers;

use App\DataAccess\Eloquent\Article;
use App\Observers\ArticleObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // 
        // refs: https://readouble.com/laravel/5.6/ja/migrations.html
        Schema::defaultStringLength(191);

        Article::observe(ArticleObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
