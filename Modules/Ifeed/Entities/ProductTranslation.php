<?php

namespace Modules\Ifeed\Entities;

use Modules\Icommerce\Entities\ProductTranslation as EntityProductsTranslation;
use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;

class ProductTranslation extends EntityProductsTranslation implements Feedable
{
    public function toFeedItem(): FeedItem
    {
        return FeedItem::create([
        ]);
    }

    public static function getFeedItems()
    {
        return ProductTranslation::orderBy('created_at', 'desc')->get();
    }
}
