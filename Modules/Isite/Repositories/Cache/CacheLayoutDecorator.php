<?php

namespace Modules\Isite\Repositories\Cache;

use Modules\Isite\Repositories\LayoutRepository;
use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;

class CacheLayoutDecorator extends BaseCacheCrudDecorator implements LayoutRepository
{
    public function __construct(LayoutRepository $layout)
    {
        parent::__construct();
        $this->entityName = 'isite.layouts';
        $this->repository = $layout;
    }
}
