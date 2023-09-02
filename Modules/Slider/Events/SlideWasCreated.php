<?php

namespace Modules\Slider\Events;

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
     */
    public function getEntity()
    {
        return $this->post;
    }

    /**
     * Return the ALL data sent
     */
    public function getSubmissionData()
    {
        return $this->data;
    }
}
