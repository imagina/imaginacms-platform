<?php

namespace Modules\Ibanners\Events;

use Illuminate\Database\Eloquent\Model;
use Modules\Ibanners\Entities\Banner;
use Modules\Media\Contracts\StoringMedia;

class BannerWasUpdated implements StoringMedia
{
    /**
     * @var array
     */
    public $data;

    /**
     * @var Banner
     */
    public $banner;

    public function __construct(Banner $banner, array $data)
    {
        $this->data = $data;
        $this->banner = $banner;
    }

    /**
     * Return the entity
     */
    public function getEntity(): Model
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
