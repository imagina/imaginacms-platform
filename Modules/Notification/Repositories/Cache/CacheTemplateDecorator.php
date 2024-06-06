<?php

namespace Modules\Notification\Repositories\Cache;

use Modules\Notification\Repositories\TemplateRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheTemplateDecorator extends BaseCacheDecorator implements TemplateRepository
{
    public function __construct(TemplateRepository $template)
    {
        parent::__construct();
        $this->entityName = 'notification.templates';
        $this->repository = $template;
    }
}
