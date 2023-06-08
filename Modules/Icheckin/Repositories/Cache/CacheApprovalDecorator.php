<?php

namespace Modules\Icheckin\Repositories\Cache;

use Modules\Icheckin\Repositories\ApprovalRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheApprovalDecorator extends BaseCacheDecorator implements ApprovalRepository
{
    public function __construct(ApprovalRepository $aprovement)
    {
        parent::__construct();
        $this->entityName = 'icheckin.aprovements';
        $this->repository = $aprovement;
    }
}
