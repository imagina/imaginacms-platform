<?php

namespace Modules\Media\Repositories\Cache;

use Modules\Media\Repositories\ZoneRepository;
use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;

class CacheZoneDecorator extends BaseCacheCrudDecorator implements ZoneRepository
{
    public function __construct(ZoneRepository $zone)
    {
        parent::__construct();
        $this->entityName = 'media.zones';
        $this->repository = $zone;
    }
}
