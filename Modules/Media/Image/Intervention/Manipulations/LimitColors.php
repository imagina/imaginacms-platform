<?php

namespace Modules\Media\Image\Intervention\Manipulations;

use Intervention\Image\Image;
use Modules\Media\Image\ImageHandlerInterface;

class LimitColors implements ImageHandlerInterface
{
    private $defaults = [
        'count' => 255,
        'matte' => null,
    ];

    /**
     * Handle the image manipulation request
     */
    public function handle(Image $image, array $options): Image
    {
        $options = array_merge($this->defaults, $options);

        return $image->limitColors($options['count'], $options['matte']);
    }
}
