<?php

namespace Modules\Isite\Repositories\Cache;

use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;
use Modules\Isite\Repositories\ModuleRepository;

class CacheModuleDecorator extends BaseCacheCrudDecorator implements ModuleRepository
{
    public function __construct(ModuleRepository $module)
    {
        parent::__construct();
        $this->entityName = 'isite.modules';
        $this->repository = $module;
    }
}
