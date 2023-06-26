<?php

namespace Modules\Iblog\Events;

use Modules\Media\Contracts\DeletingMedia;

class CategoryWasDeleted implements DeletingMedia
{
    /**
     * @var categoryClass
     */
    public $categoryClass;

    /**
     * @var categoryId
     */
    public $categoryId;

    public function __construct($categoryId, $categoryClass)
    {
        $this->categoryClass = $categoryClass;
        $this->categoryId = $categoryId;
    }

    /**
     * Get the entity ID
     */
    public function getEntityId(): int
    {
        return $this->categoryId;
    }

    /**
     * Get the class name the imageables
     */
    public function getClassName(): string
    {
        return $this->categoryClass;
    }
}
