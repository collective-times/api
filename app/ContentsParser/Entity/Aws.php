<?php

namespace App\ContentsParser\Entity;

use App\ContentsParser\EntityInterface;

class Aws extends RSS2 implements EntityInterface
{
    public function getImageUrl()
    {
        // TODO: 画像URL取得
        return '';
    }

    public function getFaviconUrl()
    {
        return '';
    }
}