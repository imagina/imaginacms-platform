<?php

namespace Modules\Media\Image\Intervention\Manipulations;

use Intervention\Image\Image;
use Modules\Media\Image\ImageHandlerInterface;

class Pixelate implements ImageHandlerInterface
{
    private $defaults = [
        'size' => 0,
    ];

    /**
     * Handle the image manipulation request
     */
    public function handle(Image $image, array $options): Image
    {
        $options = array_merge($this->defaults, $options);

        return $image->pixelate($options['size']);
    }
}
