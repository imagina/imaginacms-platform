<?php

namespace Modules\Iad\Repositories\Cache;

use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;
use Modules\Iad\Repositories\FieldRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheFieldDecorator extends BaseCacheCrudDecorator implements FieldRepository
{
    public function __construct(FieldRepository $field)
    {
        parent::__construct();
        $this->entityName = 'iad.fields';
        $this->repository = $field;
    }
}
