<?php

namespace Modules\Iblog\Events;

use Illuminate\Database\Eloquent\Model;
use Modules\Iblog\Entities\Post;
use Modules\Media\Contracts\StoringMedia;

class PostWasUpdated implements StoringMedia
{
    /**
     * @var array
     */
    public $data;

    /**
     * @var Post
     */
    public $post;

    public function __construct(Post $post, array $data)
    {
        $this->data = $data;
        $this->post = $post;
    }

    /**
     * Return the entity
     */
    public function getEntity(): Model
    {
        return $this->post;
    }

    /**
     * Return the ALL data sent
     */
    public function getSubmissionData(): array
    {
        return $this->data;
    }
}
