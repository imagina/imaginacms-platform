<?php

namespace Modules\Media\Repositories\Cache;

use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;
use Modules\Media\Repositories\ZoneRepository;

class CacheZoneDecorator extends BaseCacheCrudDecorator implements ZoneRepository
{
    public function __construct(ZoneRepository $zone)
    {
        parent::__construct();
        $this->entityName = 'media.zones';
        $this->repository = $zone;
    }
}
