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
     *
     * @return object
     */
    public function allOnline(): object
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
     *
     * @param  array  $params
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getItemsBy(array $params): Collection
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
     *
     * @param  string  $criteria
     * @param  array  $params
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getItem(string $criteria, array $params = false): Collection
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
