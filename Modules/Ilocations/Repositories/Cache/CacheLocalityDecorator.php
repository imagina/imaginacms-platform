<?php

namespace Modules\Ilocations\Repositories\Cache;

use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;
use Modules\Ilocations\Repositories\LocalityRepository;

class CacheLocalityDecorator extends BaseCacheCrudDecorator implements LocalityRepository
{
    public function __construct(LocalityRepository $locality)
    {
        parent::__construct();
        $this->entityName = 'ilocations.localities';
        $this->repository = $locality;
    }
}
