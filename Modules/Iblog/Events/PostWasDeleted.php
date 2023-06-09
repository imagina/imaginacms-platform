<?php

namespace Modules\Iblog\Events;

use Modules\Media\Contracts\DeletingMedia;

class PostWasDeleted implements DeletingMedia
{
    /**
     * @var string
     */
    private $postClass;

    /**
     * @var int
     */
    private $postId;

    public function __construct($postId, $postClass)
    {
        $this->postClass = $postClass;
        $this->postId = $postId;
    }

    /**
     * Get the entity ID
     */
    public function getEntityId(): int
    {
        return $this->postId;
    }

    /**
     * Get the class name the imageables
     */
    public function getClassName(): string
    {
        return $this->postClass;
    }
}
