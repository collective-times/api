<?php

namespace Tests\Unit\App\ContentsParser\RSS2;

use App\ContentsParser\RSS2;
use App\ContentsParser\RSS2\Entity;
use PHPUnit\Framework\TestCase;

class EntityTest extends TestCase
{
    private $data = '
<rdf:RDF xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns="http://purl.org/rss/1.0/" xmlns:admin="http://webns.net/mvcb/" xmlns:content="http://purl.org/rss/1.0/modules/content/" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:hatena="http://www.hatena.ne.jp/info/xmlns#" xmlns:syn="http://purl.org/rss/1.0/modules/syndication/" xmlns:taxo="http://purl.org/rss/1.0/modules/taxonomy/">
    <item rdf:about="http://example.blog.jp/2018/07/09/">
        <title>Example Blog Title</title>
        <link>http://example.blog.jp/2018/07/09/</link>
        <description>あいうえおかきくけこ</description>
        <dc:date>2018-07-08T11:29:46Z</dc:date>
        <content:encoded><![CDATA[
            <blockquote cite="http://example.blog.jp/2018/07/09/" title="Example Blog Title"><cite><img src="http://example.image.jp/favicon.jpg" alt="" /> <a href="http://example.blog.jp/2018/07/09/">Example Blog Title</a></cite><p><a href="http://example.blog.jp/2018/07/09/"><img src="http://example.image.jp/image.jpg" alt="Example Blog Title" title="Example Blog Title" class="entry-image" /></a></p></blockquote>
          ]]></content:encoded>
    </item>>
</rdf:RDF>
';
    private $entity;

    public function setUp()
    {
        parent::setUp();

        $rss2 = new RSS2();
        $items = $rss2->parse($this->data);
        $this->entity = $rss2->getEntity($items[0]);
    }

    public function testGetTitle_ReturnTitle()
    {
        $this->assertEquals('Example Blog Title', $this->entity->getTitle());
    }

    public function testGetDescription_ReturnDescription()
    {
        $this->assertEquals('あいうえおかきくけこ', $this->entity->getDescription());
    }

    public function testGetPublishDate()
    {
        $this->assertEquals('2018-07-08 11:29:46', $this->entity->getPublishDate());
    }

    public function testGetArticleUrl_ReturnUrl()
    {
        $this->assertEquals('http://example.blog.jp/2018/07/09/', $this->entity->getArticleUrl());
    }

    public function testGetImageUrl_ReturnUrl()
    {
        $this->assertEquals('http://example.image.jp/image.jpg', $this->entity->getImageUrl());
    }

    public function testGetFaviconUrl_ReturnUrl()
    {
        $this->assertEquals('http://example.image.jp/favicon.jpg', $this->entity->getFaviconUrl());
    }
}
