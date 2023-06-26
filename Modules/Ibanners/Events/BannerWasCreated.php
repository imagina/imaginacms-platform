<?php

namespace Modules\Ibanners\Events;

use Modules\Ibanners\Entities\Banner;
use Modules\Media\Contracts\StoringMedia;

class BannerWasCreated implements StoringMedia
{
    /**
     * @var array
     */
    public $data;

    /**
     * @var Banner
     */
    public $banner;

    public function __construct($banner, array $data)
    {
        $this->data = $data;
        $this->banner = $banner;
    }

    /**
     * Return the entity
     */
    public function getEntity(): Banner
    {
        return $this->banner;
    }

    /**
     * Return the ALL data sent
     */
    public function getSubmissionData(): array
    {
        return $this->data;
    }
}
