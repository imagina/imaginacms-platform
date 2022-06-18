<?php

namespace Modules\Isite\Repositories\Cache;

use Modules\Isite\Repositories\IcrudRepository;
use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;

class CacheIcrudDecorator extends BaseCacheCrudDecorator implements IcrudRepository
{
    public function __construct(IcrudRepository $icrud)
    {
        parent::__construct();
        $this->entityName = 'isite.icruds';
        $this->repository = $icrud;
    }
}
