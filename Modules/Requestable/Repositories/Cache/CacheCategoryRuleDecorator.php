<?php

namespace Modules\Requestable\Repositories\Cache;

use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;
use Modules\Requestable\Repositories\CategoryRuleRepository;

class CacheCategoryRuleDecorator extends BaseCacheCrudDecorator implements CategoryRuleRepository
{
    public function __construct(CategoryRuleRepository $categoryrule)
    {
        parent::__construct();
        $this->entityName = 'requestable.categoryrules';
        $this->repository = $categoryrule;
    }
}
