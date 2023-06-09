<?php

namespace Modules\Slider\Events;

use Illuminate\Database\Eloquent\Model;
use Modules\Media\Contracts\StoringMedia;

class SlideWasCreated implements StoringMedia
{
    /**
     * @var array
     */
    public $data;

    /**
     * @var Post
     */
    public $post;

    public function __construct($post, array $data)
    {
        $this->data = $data;
        $this->post = $post;
    }

    /**
     * Return the entity
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getEntity(): Model
    {
        return $this->post;
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
