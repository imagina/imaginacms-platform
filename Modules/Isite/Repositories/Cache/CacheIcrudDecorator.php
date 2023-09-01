<?php

namespace Modules\Isite\Repositories\Cache;

use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;
use Modules\Isite\Repositories\IcrudRepository;

class CacheIcrudDecorator extends BaseCacheCrudDecorator implements IcrudRepository
{
    public function __construct(IcrudRepository $icrud)
    {
        parent::__construct();
        $this->entityName = 'isite.icruds';
        $this->repository = $icrud;
    }
}
