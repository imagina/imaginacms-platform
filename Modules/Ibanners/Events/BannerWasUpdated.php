<?php

namespace Modules\Ibanners\Events;

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
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getEntity()
    {
        return $this->banner;
    }

    /**
     * Return the ALL data sent
     *
     * @return array
     */
    public function getSubmissionData()
    {
        return $this->data;
    }
}
