<?php

namespace Modules\Isite\Repositories\Cache;

use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;
use Modules\Isite\Repositories\RevisionRepository;

class CacheRevisionDecorator extends BaseCacheCrudDecorator implements RevisionRepository
{
    public function __construct(RevisionRepository $revision)
    {
        parent::__construct();
        $this->entityName = 'isite.revisions';
        $this->repository = $revision;
    }
}
