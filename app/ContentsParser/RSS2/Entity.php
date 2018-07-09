<?php

namespace App\ContentsParser\RSS2;

use App\ContentsParser\EntityInterface;
use Carbon\Carbon;
use Symfony\Component\DomCrawler\Crawler;

class Entity implements EntityInterface
{
    private $item;
    private $nameSpace;
    private $crawler;

    public function __construct($item, $nameSpace)
    {
        $this->item = $item;
        $this->nameSpace = $nameSpace;
    }

    public function getTitle()
    {
        return $this->item->title;
    }

    public function getDescription()
    {
        return $this->item->description;
    }

    public function getPublishDate()
    {
        $nameSpacedItem = $this->item->children($this->nameSpace['dc']);
        $date = new Carbon($nameSpacedItem->date);
        return $date->toDateTimeString();
    }

    public function getArticleUrl()
    {
        return $this->item->link;
    }

    public function getImageUrl()
    {
        return $this->createCrawlerObject()->filter('body img')->eq(1)->attr('src');
    }

    public function getFaviconUrl()
    {
        return $this->createCrawlerObject()->filter('body img')->eq(0)->attr('src');
    }

    private function createCrawlerObject()
    {
        if (!is_null($this->crawler)) {
            return $this->crawler;
        }

        $nameSpacedItem = $this->item->children($this->nameSpace['content']);
        $this->crawler = new Crawler(null);
        $this->crawler->addHtmlContent((string) $nameSpacedItem->encoded);

        return $this->crawler;
    }
}