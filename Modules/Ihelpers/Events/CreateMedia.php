<?php

namespace Modules\Ihelpers\Events;

use Illuminate\Database\Eloquent\Model;
use Modules\Media\Contracts\StoringMedia;

class CreateMedia implements StoringMedia
{
    public $data;

    public $post;

    public function __construct($post, array $data)
    {
        $this->post = $post;
        $this->data = $data;
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
