<?php

namespace Modules\Ifillable\Repositories\Cache;

use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;
use Modules\Ifillable\Repositories\FieldRepository;

class CacheFieldDecorator extends BaseCacheCrudDecorator implements FieldRepository
{
    public function __construct(FieldRepository $field)
    {
        parent::__construct();
        $this->entityName = 'ifillable.fields';
        $this->repository = $field;
    }
}
