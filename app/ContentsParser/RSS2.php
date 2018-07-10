<?php

namespace App\ContentsParser;

use App\ContentsParser\RSS2\Entity;
use SimplePie;

class RSS2
{
    private $feed;

    public function __construct()
    {
        $this->feed = new SimplePie();
    }

    public function request($url)
    {
        $this->feed->set_feed_url($url);
        $this->feed->handle_content_type();
        $this->feed->enable_cache(false);
        $this->feed->init();

        return $this->feed->get_items();
    }

    public static function getEntity($item)
    {
        return new Entity($item);
    }
}