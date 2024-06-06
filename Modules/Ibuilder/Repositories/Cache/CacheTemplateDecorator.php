<?php

namespace Modules\Ibuilder\Repositories\Cache;

use Modules\Ibuilder\Repositories\TemplateRepository;
use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;

class CacheTemplateDecorator extends BaseCacheCrudDecorator implements TemplateRepository
{
    public function __construct(TemplateRepository $template)
    {
        parent::__construct();
        $this->entityName = 'ibuilder.templates';
        $this->repository = $template;
    }
}
