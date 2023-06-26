<?php

namespace Modules\Media\Events;

class FileWasUnlinked
{
    /**
     * The imageable id
     *
     * @var int
     */
    public $imageableId;

    public function __construct(int $imageableId)
    {
        $this->imageableId = $imageableId;
    }
}
