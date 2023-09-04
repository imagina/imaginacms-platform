<?php

namespace Modules\Ibanners\Repositories\Cache;

use Illuminate\Database\Eloquent\Collection;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;
use Modules\Ibanners\Repositories\PositionRepository;

class CachePositionDecorator extends BaseCacheDecorator implements PositionRepository
{
    /**
     * @var SliderRepository
     */
    protected $repository;

    public function __construct(SliderRepository $position)
    {
        parent::__construct();
        $this->entityName = 'position';
        $this->repository = $position;
    }

    /**
     * Get all online position
     */
    public function allOnline()
    {
        return $this->cache
            ->tags($this->entityName, 'global')
            ->remember("{$this->locale}.{$this->entityName}.allOnline", $this->cacheTime,
                function () {
                    return $this->repository->allOnline();
                }
            );
    }

    /**
     * Get all the read notifications for the given filters
     */
    public function getItemsBy($params)
    {
        return $this->cache
            ->tags([$this->entityName, 'global'])
            ->remember(
                "{$this->locale}.{$this->entityName}.getItemBy",
                $this->cacheTime,
                function () use ($params) {
                    return $this->repository->getItemsBy($params);
                }
            );
    }

    /**
     * Get the read notification for the given filters
     */
    public function getItem(string $criteria, $params = false)
    {
        return $this->cache
            ->tags([$this->entityName, 'global'])
            ->remember(
                "{$this->locale}.{$this->entityName}.getItem",
                $this->cacheTime,
                function () use ($criteria, $params) {
                    return $this->repository->getItem($criteria, $params);
                }
            );
    }
}
