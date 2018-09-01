<?php

namespace App\ContentsParser;

use SimplePie;

class Request
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
}