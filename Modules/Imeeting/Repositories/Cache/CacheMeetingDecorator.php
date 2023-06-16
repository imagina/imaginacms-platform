<?php

namespace Modules\Imeeting\Repositories\Cache;

use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;
use Modules\Imeeting\Repositories\MeetingRepository;

class CacheMeetingDecorator extends BaseCacheCrudDecorator implements MeetingRepository
{
    public function __construct(MeetingRepository $meeting)
    {
        parent::__construct();
        $this->entityName = 'imeeting.meetings';
        $this->repository = $meeting;
    }
}
