<?php

namespace App\ContentsParser;


interface EntityInterface
{
    public function getTitle();
    public function getDescription();
    public function getPublishDate();
    public function getArticleUrl();
    public function getImageUrl();
    public function getFaviconUrl();
}