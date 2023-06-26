<?php

namespace Modules\User\Repositories\Cache;

use Illuminate\Database\Eloquent\Collection;
use Modules\User\Entities\UserToken;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;
use Modules\User\Repositories\UserTokenRepository;

class CacheUserTokenDecorator extends BaseCacheDecorator implements UserTokenRepository
{
    /**
     * @var UserTokenRepository
     */
    protected $repository;

    public function __construct(UserTokenRepository $repository)
    {
        parent::__construct();
        $this->entityName = 'user-tokens';
        $this->repository = $repository;
    }

    /**
     * Get all tokens for the given user
     *
     * @param  int  $userId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function allForUser(int $userId): Collection
    {
        $this->remember(function () use ($userId) {
            return $this->repository->allForUser($userId);
        });
    }

    /**
     * @param  int  $userId
     * @return \Modules\User\Entities\UserToken
     */
    public function generateFor(int $userId): UserToken
    {
        $this->clearCache();

        return $this->repository->generateFor($userId);
    }
}
