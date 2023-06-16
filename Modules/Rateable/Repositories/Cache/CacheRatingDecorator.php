<?php

namespace Modules\Rateable\Repositories\Cache;

use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;
use Modules\Rateable\Repositories\RatingRepository;

class CacheRatingDecorator extends BaseCacheCrudDecorator implements RatingRepository
{
    public function __construct(RatingRepository $rating)
    {
        parent::__construct();
        $this->entityName = 'rateable.ratings';
        $this->repository = $rating;
    }
}
