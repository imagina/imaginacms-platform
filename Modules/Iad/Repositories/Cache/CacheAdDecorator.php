<?php

namespace Modules\Iad\Repositories\Cache;

use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;
use Modules\Iad\Repositories\AdRepository;

class CacheAdDecorator extends BaseCacheCrudDecorator implements AdRepository
{
    public function __construct(AdRepository $ad)
    {
        parent::__construct();
        $this->entityName = 'iad.ads';
        $this->repository = $ad;
    }
}
