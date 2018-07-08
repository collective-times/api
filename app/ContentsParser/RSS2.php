<?php

namespace App\ContentsParser;

use App\ContentsParser\RSS2\Entity;

class RSS2
{
    private $rss;

    public function parse($contents)
    {
        $this->rss = simplexml_load_string($contents);
        return $this->rss->item;
    }

    public function getEntity($item)
    {
        $nameSpaces = $this->rss->getNamespaces(true);
        return new Entity($item, $nameSpaces);
    }
}