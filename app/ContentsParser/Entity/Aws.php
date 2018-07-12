<?php

namespace App\ContentsParser\Entity;

use App\ContentsParser\EntityInterface;
use InvalidArgumentException;

class Aws extends RSS2 implements EntityInterface
{
    public function getImageUrl()
    {
        try {
            return $this->createCrawler($this->item->get_content())->filter('body img')->eq(0)->attr('src');
        } catch (InvalidArgumentException $e) {
        }
    }

    public function getFaviconUrl()
    {
        return '';
    }
}