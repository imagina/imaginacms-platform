<?php

namespace Modules\Ilocations\Repositories\Cache;

use Modules\Ilocations\Repositories\LocalityRepository;
use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;

class CacheLocalityDecorator extends BaseCacheCrudDecorator implements LocalityRepository
{
    public function __construct(LocalityRepository $locality)
    {
        parent::__construct();
        $this->entityName = 'ilocations.localities';
        $this->repository = $locality;
    }
}
