<?php

namespace Modules\Ibanners\Events;

use Modules\Media\Contracts\DeletingMedia;

class BannerWasDeleted implements DeletingMedia
{
    /**
     * @var string
     */
    private $bannerClass;

    /**
     * @var int
     */
    private $bannerId;

    public function __construct($bannerId, $bannerClass)
    {
        $this->bannerClass = $bannerClass;
        $this->bannerId = $bannerId;
    }

    /**
     * Get the entity ID
     *
     * @return int
     */
    public function getEntityId(): int
    {
        return $this->bannerId;
    }

    /**
     * Get the class name the imageables
     *
     * @return string
     */
    public function getClassName(): string
    {
        return $this->bannerClass;
    }
}
