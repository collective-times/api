<?php

namespace App\Crawl;


interface EntityInterface
{
    public function getTitle();
    public function getDescription();
    public function getPublishDate();
    public function getArticleUrl();
}