<?php

namespace Modules\Icomments\Traits;

use Modules\Icomments\Entities\Comment;

trait Commenter
{
    /**
     * Returns all comments that this user has made.
     */
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commenter');
    }

    /**
     * Returns only approved comments that this user has made.
     */
    public function approvedComments()
    {
        return $this->morphMany(Comment::class, 'commenter')->where('approved', true);
    }
}
