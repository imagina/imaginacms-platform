<?php

namespace Modules\Notification\Repositories\Cache;

use Illuminate\Database\Eloquent\Collection;
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

    public function latestForUser(int $userId): Collection
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
     */
    public function markNotificationAsRead(int $notificationId): bool
    {
        $this->cache->tags($this->entityName)->flush();

        return $this->repository->markNotificationAsRead($notificationId);
    }

    /**
     * Get all the notifications for the given user id
     */
    public function allForUser(int $userId): Collection
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
     */
    public function allReadForUser(int $userId): Collection
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
     */
    public function allUnreadForUser(int $userId): Collection
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
     */
    public function deleteAllForUser(int $userId): bool
    {
        $this->cache->tags($this->entityName)->flush();

        return $this->repository->deleteAllForUser($userId);
    }

    /**
     * Mark all the notifications for the given user as read
     */
    public function markAllAsReadForUser(int $userId): bool
    {
        $this->cache->tags($this->entityName)->flush();

        return $this->repository->markAllAsReadForUser($userId);
    }

    /**
     * Get all the read notifications for the given filters
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

    /**
     * Update the notifications for the given ids
     */
    public function updateItems(array $criterias, array $data): bool
    {
        $this->cache->tags($this->entityName)->flush();

        return $this->repository->updateItems($criterias, $data);
    }

    /**
     * Delete the notifications for the given ids
     */
    public function deleteItems(array $criterias): bool
    {
        $this->cache->tags($this->entityName)->flush();

        return $this->repository->deleteItems($criterias);
    }
}
