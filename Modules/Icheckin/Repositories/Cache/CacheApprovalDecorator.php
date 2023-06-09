<?php

namespace Modules\Icheckin\Repositories\Cache;

use Modules\Core\Repositories\Cache\BaseCacheDecorator;
use Modules\Icheckin\Repositories\ApprovalRepository;

class CacheApprovalDecorator extends BaseCacheDecorator implements ApprovalRepository
{
    public function __construct(ApprovalRepository $aprovement)
    {
        parent::__construct();
        $this->entityName = 'icheckin.aprovements';
        $this->repository = $aprovement;
    }
}
