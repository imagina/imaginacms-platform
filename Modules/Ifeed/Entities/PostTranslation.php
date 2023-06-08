<?php

namespace Modules\Ifeed\Entities;

use Modules\Iblog\Entities\PostTranslation as EntityPostTranslation;
use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;

class PostTranslation extends EntityPostTranslation implements Feedable
{
  public function toFeedItem(): FeedItem
  {
    return FeedItem::create([
      'title' => $this->title,
      'summary' => $this->summary,
      'link' => $this->url
    ]);
  }

  public static function getFeedItems()
  {
    return Post::orderBy('created_at', 'desc')->get();
  }
}
