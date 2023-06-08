<?php

namespace Modules\Ifollow\Traits;

use Modules\Ifollow\Entities\Follower;

trait isFollowable
{

    /**
     * Relation morphMany Followers
     */
    public function followers()
    {
        return $this->morphMany(Follower::class,"followable")->with("user");
    }
}
