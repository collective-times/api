<?php

namespace App\ContentsParser\RSS2;

use App\ContentsParser\EntityInterface;
use Carbon\Carbon;
use Symfony\Component\DomCrawler\Crawler;

class Entity implements EntityInterface
{
    private $item;
    private $nameSpace;

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
        $nameSpacedItem = $this->item->children($this->nameSpace['content']);
        $crawler = new Crawler(null);
        $crawler->addHtmlContent((string) $nameSpacedItem->encoded);

        return $crawler->filter('body img')->eq(1)->attr('src');
    }

    public function getFaviconUrl()
    {
        $nameSpacedItem = $this->item->children($this->nameSpace['content']);
        $crawler = new Crawler(null);
        $crawler->addHtmlContent((string) $nameSpacedItem->encoded);

        return $crawler->filter('body img')->eq(0)->attr('src');
    }
}