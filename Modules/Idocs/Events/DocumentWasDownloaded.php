<?php

namespace Modules\Idocs\Events;

class DocumentWasDownloaded
{
    /**
     * @var array
     */
    public $key;

    /**
     * @var Post
     */
    public $document;

    public function __construct($document, $key = null)
    {
        $this->key = $key;
        $this->document = $document;
    }
}
