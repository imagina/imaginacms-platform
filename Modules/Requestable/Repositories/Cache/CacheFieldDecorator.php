<?php

namespace Modules\Requestable\Repositories\Cache;

use Modules\Requestable\Repositories\FieldRepository;
use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;

class CacheFieldDecorator extends BaseCacheCrudDecorator implements FieldRepository
{
    public function __construct(FieldRepository $field)
    {
        parent::__construct();
        $this->entityName = 'requestable.fields';
        $this->repository = $field;
    }
}
