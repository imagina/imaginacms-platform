<?php

namespace Modules\Notification\Repositories\Cache;

use Modules\Core\Repositories\Cache\BaseCacheDecorator;
use Modules\Notification\Repositories\NotificationRepository;

class CacheNotificationDecorator extends BaseCacheDecorator implements NotificationRepository
{
    public function __construct(NotificationRepository $notification)
    {
        parent::__construct();
        $this->entityName = 'notification.notifications';
        $this->repository = $notification;
    }

    /**
     * @param int $userId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function latestForUser($userId)
    {
        return $this->cache
            ->tags([$this->entityName, 'global'])
            ->remember(
                "{$this->locale}.{$this->entityName}.latestForUser.{$userId}",
                $this->cacheTime,
                function () use ($userId) {
                    return $this->repository->latestForUser($userId);
                }
            );
    }

    /**
     * Mark the given notification id as "read"
     * @param int $notificationId
     * @return bool
     */
    public function markNotificationAsRead($notificationId)
    {
        $this->cache->tags($this->entityName)->flush();

        return $this->repository->markNotificationAsRead($notificationId);
    }

    /**
     * Get all the notifications for the given user id
     * @param int $userId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function allForUser($userId)
    {
        return $this->cache
            ->tags([$this->entityName, 'global'])
            ->remember(
                "{$this->locale}.{$this->entityName}.allForUser.{$userId}",
                $this->cacheTime,
                function () use ($userId) {
                    return $this->repository->allForUser($userId);
                }
            );
    }

    /**
     * Get all the read notifications for the given user id
     * @param int $userId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function allReadForUser($userId)
    {
        return $this->cache
            ->tags([$this->entityName, 'global'])
            ->remember(
                "{$this->locale}.{$this->entityName}.allReadForUser.{$userId}",
                $this->cacheTime,
                function () use ($userId) {
                    return $this->repository->allReadForUser($userId);
                }
            );
    }

    /**
     * Get all the unread notifications for the given user id
     * @param int $userId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function allUnreadForUser($userId)
    {
        return $this->cache
            ->tags([$this->entityName, 'global'])
            ->remember(
                "{$this->locale}.{$this->entityName}.allUnreadForUser.{$userId}",
                $this->cacheTime,
                function () use ($userId) {
                    return $this->repository->allUnreadForUser($userId);
                }
            );
    }

    /**
     * Delete all the notifications for the given user
     * @param int $userId
     * @return bool
     */
    public function deleteAllForUser($userId)
    {
        $this->cache->tags($this->entityName)->flush();

        return $this->repository->deleteAllForUser($userId);
    }

    /**
     * Mark all the notifications for the given user as read
     * @param int $userId
     * @return bool
     */
    public function markAllAsReadForUser($userId)
    {
        $this->cache->tags($this->entityName)->flush();

        return $this->repository->markAllAsReadForUser($userId);
    }

    /**
     * Get all the read notifications for the given filters
     * @param array $params
     * @return \Illuminate\Database\Eloquent\Collection
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
     * @param string $criteria
     * @param array $params
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getItem($criteria, $params)
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

    /**
     * Update the notifications for the given ids
     * @param array $criterias
     * @param array $data
     * @return bool
     */
    public function updateItems($criterias, $data)
    {
        $this->cache->tags($this->entityName)->flush();

        return $this->repository->updateItems($criterias, $data);
    }

    /**
     * Delete the notifications for the given ids
     * @param array $criterias
     * @return bool
     */
    public function deleteItems($criterias)
    {
        $this->cache->tags($this->entityName)->flush();

        return $this->repository-> deleteItems($criterias);
    }
}
