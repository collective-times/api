<?php

namespace App\Crawl\RSS2;

use App\Crawl\EntityInterface;
use Carbon\Carbon;

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
}