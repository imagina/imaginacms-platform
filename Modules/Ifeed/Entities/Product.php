<?php

namespace Modules\Ifeed\Entities;

use Modules\Icommerce\Entities\Product as EntityProducts;
use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;
use Astrotomic\Translatable\Translatable;

class Product extends EntityProducts implements Feedable
{
  public function toFeedItem(): FeedItem
  {
    return FeedItem::create([
      'id' => $this->id,
      'title' => $this->name,
      'summary' => $this->summary,
      'author' => @setting('core::site-name'),
      'updated' => $this->updated_at,
      'link' => $this->url,
      'status' => $this->status,
    ]);
  }
  public static function getFeedItems()
  {
    return Product::orderBy('updated_at', 'desc')->limit(setting('ifeed::limitProductsRss'))->get();
  }
}