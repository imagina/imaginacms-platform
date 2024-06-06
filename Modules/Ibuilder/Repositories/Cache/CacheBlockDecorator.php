<?php

namespace Modules\Ibuilder\Repositories\Cache;

use Modules\Ibuilder\Repositories\BlockRepository;
use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;

class CacheBlockDecorator extends BaseCacheCrudDecorator implements BlockRepository
{
    public function __construct(BlockRepository $block)
    {
        parent::__construct();
        $this->entityName = 'ibuilder.blocks';
        $this->repository = $block;
    }
}
