<?php

namespace Modules\Notification\Repositories\Cache;

use Modules\Notification\Repositories\TemplateRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheTemplateDecorator extends BaseCacheDecorator implements TemplateRepository
{
    public function __construct(TemplateRepository $template)
    {
        parent::__construct();
        $this->entityName = 'notification.templates';
        $this->repository = $template;
    }

    public function getItemsBy($params)
    {
        return $this->remember(function () use ($params) {
            return $this->repository->getItemsBy($params);
        });
    }

    public function getItem($criteria, $params = false)
    {
        return $this->remember(function () use ($criteria, $params) {
            return $this->repository->getItem($criteria, $params);
        });
    }

    public function updateBy($criteria, $data, $params = false)
    {
        $this->clearCache();

        return $this->repository->updateBy($criteria, $data, $params);
    }

    public function deleteBy($criteria, $params = false)
    {
        $this->clearCache();

        return $this->repository->deleteBy($criteria, $params);
    }
}
