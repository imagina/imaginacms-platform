<?php

namespace Modules\Isite\Repositories\Cache;

use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;
use Modules\Isite\Repositories\RecommendationRepository;

class CacheRecommendationDecorator extends BaseCacheCrudDecorator implements RecommendationRepository
{
    public function __construct(RecommendationRepository $recommendation)
    {
        parent::__construct();
        $this->entityName = 'isite.recommendations';
        $this->repository = $recommendation;
    }
}
