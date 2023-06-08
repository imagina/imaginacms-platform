<?php

namespace Modules\Idocs\Events;

use Modules\Idocs\Entities\Document;
use Modules\Media\Contracts\StoringMedia;

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
