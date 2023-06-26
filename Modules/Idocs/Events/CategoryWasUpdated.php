<?php

namespace Modules\Idocs\Events;

use Illuminate\Database\Eloquent\Model;
use Modules\Idocs\Entities\Category;
use Modules\Media\Contracts\StoringMedia;

class CategoryWasUpdated implements StoringMedia
{
    /**
     * @var array
     */
    public $data;

    /**
     * @var Category
     */
    public $category;

    public function __construct(Category $category, array $data)
    {
        $this->data = $data;
        $this->category = $category;
    }

    /**
     * Return the entity
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getEntity(): Model
    {
        return $this->category;
    }

    /**
     * Return the ALL data sent
     *
     * @return array
     */
    public function getSubmissionData(): array
    {
        return $this->data;
    }
}
