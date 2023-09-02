<?php

namespace Modules\Idocs\Events;

use Modules\Media\Contracts\StoringMedia;

class DocumentWasCreated implements StoringMedia
{
    /**
     * @var array
     */
    public $data;

    /**
     * @var Post
     */
    public $document;

    public function __construct($document, array $data)
    {
        $this->data = $data;
        $this->document = $document;
    }

    /**
     * Return the entity
     */
    public function getEntity()
    {
        return $this->document;
    }

    /**
     * Return the ALL data sent
     */
    public function getSubmissionData()
    {
        return $this->data;
    }
}
