<?php

namespace Modules\Requestable\Repositories\Cache;

use Modules\Requestable\Repositories\CategoryRuleRepository;
use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;

class CacheCategoryRuleDecorator extends BaseCacheCrudDecorator implements CategoryRuleRepository
{
    public function __construct(CategoryRuleRepository $categoryrule)
    {
        parent::__construct();
        $this->entityName = 'requestable.categoryrules';
        $this->repository = $categoryrule;
    }
}
