<?php

namespace Modules\Page\Events;

use Illuminate\Database\Eloquent\Model;
use Modules\Media\Contracts\StoringMedia;
use Modules\Page\Entities\Page;

class PageWasCreated implements StoringMedia
{
    /**
     * @var array
     */
    public $data;

    /**
     * @var Page
     */
    public $page;

    public function __construct(Page $page, array $data)
    {
        $this->data = $data;
        $this->page = $page;
    }

    /**
     * Return the entity
     */
    public function getEntity(): Model
    {
        return $this->page;
    }

    /**
     * Return the ALL data sent
     */
    public function getSubmissionData(): array
    {
        return $this->data;
    }
}
