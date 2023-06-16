<?php

namespace Modules\Isite\Repositories\Cache;

use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;
use Modules\Isite\Repositories\TypeableRepository;

class CacheTypeableDecorator extends BaseCacheCrudDecorator implements TypeableRepository
{
    public function __construct(TypeableRepository $typeable)
    {
        parent::__construct();
        $this->entityName = 'isite.typeables';
        $this->repository = $typeable;
    }
}
