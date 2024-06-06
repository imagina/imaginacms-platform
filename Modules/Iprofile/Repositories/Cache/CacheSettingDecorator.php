<?php

namespace Modules\Iprofile\Repositories\Cache;

use Modules\Iprofile\Repositories\SettingRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheSettingDecorator extends BaseCacheDecorator implements SettingRepository
{
    public function __construct(SettingRepository $departmentsetting)
    {
        parent::__construct();
        $this->entityName = 'iprofile.departmentsettings';
        $this->repository = $departmentsetting;
    }
}
