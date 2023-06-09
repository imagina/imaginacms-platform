<?php

namespace Modules\Ifeed\Entities;

use Modules\Iblog\Entities\Post as EntityPost;
use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;

class Post extends EntityPost implements Feedable
{
    public function toFeedItem(): FeedItem
    {
        return FeedItem::create([
            'id' => $this->id,
            'title' => $this->title,
            'summary' => $this->summary,
            'author' => $this->user->present()->fullname,
            'updated' => $this->updated_at,
            'link' => $this->url,
            'status' => $this->status,
        ]);
    }

    public static function getFeedItems()
    {
        return Post::orderBy('updated_at', 'desc')->limit(setting('ifeed::limitPostsRss'))->get();
    }
}
