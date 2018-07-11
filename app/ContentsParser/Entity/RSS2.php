<?php

namespace App\ContentsParser\Entity;

use App\ContentsParser\EntityInterface;
use Symfony\Component\DomCrawler\Crawler;

class RSS2 implements EntityInterface
{
    private $item;

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
        return $this->createCrawler($this->item->get_content())->filter('body img')->eq(1)->attr('src');
    }

    public function getFaviconUrl()
    {
        return $this->createCrawler($this->item->get_content())->filter('body img')->eq(0)->attr('src');
    }

    private function createCrawler($content)
    {
        $crawler = new Crawler(null);
        $crawler->addHtmlContent($content);

        return $crawler;
    }
}