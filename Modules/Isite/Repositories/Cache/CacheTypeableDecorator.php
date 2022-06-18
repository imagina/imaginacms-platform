<?php

namespace Modules\Isite\Repositories\Cache;

use Modules\Isite\Repositories\TypeableRepository;
use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;

class CacheTypeableDecorator extends BaseCacheCrudDecorator implements TypeableRepository
{
    public function __construct(TypeableRepository $typeable)
    {
        parent::__construct();
        $this->entityName = 'isite.typeables';
        $this->repository = $typeable;
    }
}
