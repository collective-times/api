<?php

namespace App\ContentsParser\Entity;

use App\ContentsParser\EntityInterface;

class Hatena extends RSS2 implements EntityInterface
{
    public function getImageUrl()
    {
        return $this->createCrawler($this->item->get_content())->filter('body img')->eq(1)->attr('src');
    }

    public function getFaviconUrl()
    {
        return $this->createCrawler($this->item->get_content())->filter('body img')->eq(0)->attr('src');
    }
}