<?php

namespace Modules\Ifillable\Repositories\Cache;

use Modules\Ifillable\Repositories\FieldRepository;
use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;

class CacheFieldDecorator extends BaseCacheCrudDecorator implements FieldRepository
{
    public function __construct(FieldRepository $field)
    {
        parent::__construct();
        $this->entityName = 'ifillable.fields';
        $this->repository = $field;
    }
}
