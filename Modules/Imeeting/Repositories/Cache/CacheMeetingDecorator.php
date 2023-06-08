<?php

namespace Modules\Imeeting\Repositories\Cache;

use Modules\Imeeting\Repositories\MeetingRepository;
use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;

class CacheMeetingDecorator extends BaseCacheCrudDecorator implements MeetingRepository
{
    public function __construct(MeetingRepository $meeting)
    {
        parent::__construct();
        $this->entityName = 'imeeting.meetings';
        $this->repository = $meeting;
    }
}
