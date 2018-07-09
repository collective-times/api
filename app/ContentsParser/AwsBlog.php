<?php

namespace App\ContentsParser;

use App\ContentsParser\AwsBlog\Entity;

class AwsBlog
{
    private $rss;

    public function parse($contents)
    {
        $this->rss = simplexml_load_string($contents);
        return $this->rss->channel->item;
    }

    public function getEntity($item)
    {
        $nameSpaces = $this->rss->getNamespaces(true);
        return new Entity($item, $nameSpaces);
    }
}