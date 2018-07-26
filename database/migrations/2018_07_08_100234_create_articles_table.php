<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('site_id')->unsigned()->nullable(); // MEMO: sitesテーブルへの移行期間中のみnullableにする。開発が終わったらnullable()削除する。
            $table->foreign('site_id')->references('id')->on('sites');
            $table->dateTime('publish_date')->nullable();
            $table->string('title');
            $table->text('description')->nullable();
            $table->text('article_url');
            $table->text('source_url');
            $table->text('image_url')->nullable();
            $table->text('favicon_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
}
