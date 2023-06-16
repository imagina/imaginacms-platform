<?php

namespace Modules\Notification\Repositories\Cache;

use Modules\Core\Repositories\Cache\BaseCacheDecorator;
use Modules\Notification\Repositories\NotificationTypeRepository;

class CacheNotificationTypeDecorator extends BaseCacheDecorator implements NotificationTypeRepository
{
    public function __construct(NotificationTypeRepository $notificationtype)
    {
        parent::__construct();
        $this->entityName = 'notification.notificationtypes';
        $this->repository = $notificationtype;
    }
}
