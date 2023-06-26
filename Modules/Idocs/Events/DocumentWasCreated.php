<?php

namespace Modules\Idocs\Events;

use Illuminate\Database\Eloquent\Model;
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
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getEntity(): Model
    {
        return $this->document;
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
