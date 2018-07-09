<?php

namespace App\ContentsParser\AwsBlog;

use App\ContentsParser\EntityInterface;
use Carbon\Carbon;
use InvalidArgumentException;
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
        $date = new Carbon($this->item->pubDate);
        return $date->toDateTimeString();
    }

    public function getArticleUrl()
    {
        return $this->item->link;
    }

    public function getImageUrl()
    {
        try {
            return $this->createCrawlerObject()->filter('body img')->eq(0)->attr('src');
        } catch (InvalidArgumentException $e) {
            return null;
        }
    }

    public function getFaviconUrl()
    {
        try {
            return $this->createCrawlerObject()->filter('body img')->eq(1)->attr('src');
        } catch (InvalidArgumentException $e) {
            return null;
        }
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