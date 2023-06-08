<?php

namespace Modules\Rateable\Repositories\Cache;

use Modules\Rateable\Repositories\RatingRepository;
use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;

class CacheRatingDecorator extends BaseCacheCrudDecorator implements RatingRepository
{
    public function __construct(RatingRepository $rating)
    {
        parent::__construct();
        $this->entityName = 'rateable.ratings';
        $this->repository = $rating;
    }
}
