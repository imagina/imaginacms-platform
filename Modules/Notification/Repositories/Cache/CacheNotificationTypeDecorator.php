<?php

namespace Modules\Notification\Repositories\Cache;

use Modules\Notification\Repositories\NotificationTypeRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheNotificationTypeDecorator extends BaseCacheDecorator implements NotificationTypeRepository
{
    public function __construct(NotificationTypeRepository $notificationtype)
    {
        parent::__construct();
        $this->entityName = 'notification.notificationtypes';
        $this->repository = $notificationtype;
    }
}
