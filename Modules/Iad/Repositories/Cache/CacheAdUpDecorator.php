<?php

namespace Modules\Iad\Repositories\Cache;

use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;
use Modules\Iad\Repositories\AdUpRepository;

class CacheAdUpDecorator extends BaseCacheCrudDecorator implements AdUpRepository
{
    public function __construct(AdUpRepository $adup)
    {
        parent::__construct();
        $this->entityName = 'iad.adups';
        $this->repository = $adup;
    }
}
