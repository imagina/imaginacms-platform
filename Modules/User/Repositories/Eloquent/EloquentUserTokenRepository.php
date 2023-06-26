<?php

namespace Modules\User\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Collection;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Modules\User\Entities\UserToken;
use Modules\User\Repositories\UserTokenRepository;
use Ramsey\Uuid\Uuid;

class EloquentUserTokenRepository extends EloquentBaseRepository implements UserTokenRepository
{
    /**
     * Get all tokens for the given user
     */
    public function allForUser(int $userId): Collection
    {
        return $this->model->where('user_id', $userId)->get();
    }

    public function generateFor(int $userId): UserToken
    {
        $uuid4 = Uuid::uuid4();

        return $this->model->create(['user_id' => $userId, 'access_token' => $uuid4]);
    }
}
