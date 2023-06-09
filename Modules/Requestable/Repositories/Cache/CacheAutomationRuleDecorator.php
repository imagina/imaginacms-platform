<?php

namespace Modules\Requestable\Repositories\Cache;

use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;
use Modules\Requestable\Repositories\AutomationRuleRepository;

class CacheAutomationRuleDecorator extends BaseCacheCrudDecorator implements AutomationRuleRepository
{
    public function __construct(AutomationRuleRepository $automationrule)
    {
        parent::__construct();
        $this->entityName = 'requestable.automationrules';
        $this->repository = $automationrule;
    }
}
