<?php

namespace Modules\Media\Image\Intervention\Manipulations;

use Intervention\Image\Image;
use Modules\Media\Image\ImageHandlerInterface;

class Crop implements ImageHandlerInterface
{
    private $defaults = [
        'width' => '100',
        'height' => '100',
        'x' => null,
        'y' => null,
    ];

    /**
     * Handle the image manipulation request
     *
     * @return mixed
     */
    public function handle(Image $image, array $options)
    {
        $options = array_merge($this->defaults, $options);

        return $image->crop($options['width'], $options['height'], $options['x'], $options['y']);
    }
}
