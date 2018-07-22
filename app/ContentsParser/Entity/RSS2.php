<?php

namespace App\ContentsParser\Entity;

use App\ContentsParser\EntityInterface;
use InvalidArgumentException;

class RSS2 implements EntityInterface
{
    protected $item;

    public function __construct($item)
    {
        $this->item = $item;
    }

    public function getTitle()
    {
        return $this->item->get_title();
    }

    public function getDescription()
    {
        return $this->item->get_description();
    }

    public function getPublishDate()
    {
        return $this->item->get_date('Y-m-d H:i:s');
    }

    public function getArticleUrl()
    {
        return $this->item->get_link();
    }

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