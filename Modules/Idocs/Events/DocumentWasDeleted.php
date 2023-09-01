<?php

namespace Modules\Idocs\Events;

use Modules\Media\Contracts\DeletingMedia;

class DocumentWasDeleted implements DeletingMedia
{
    /**
     * @var string
     */
    private $documentClass;

    /**
     * @var int
     */
    private $documentId;

    public function __construct($documentId, $documentClass)
    {
        $this->documentClass = $documentClass;
        $this->documentId = $documentId;
    }

    /**
     * Get the entity ID
     */
    public function getEntityId(): int
    {
        return $this->documentId;
    }

    /**
     * Get the class name the imageables
     */
    public function getClassName(): string
    {
        return $this->documentClass;
    }
}
