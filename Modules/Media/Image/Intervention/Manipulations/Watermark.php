<?php

namespace Modules\Media\Image\Intervention\Manipulations;

use Modules\Media\Image\ImageHandlerInterface;

class Watermark implements ImageHandlerInterface
{
    private $defaults = [
        'source' => 'public/assets/watermark.png',
        'position' => 'bottom-right',
        'x' => null,
        'y' => null,
    ];

    /**
     * Handle the image manipulation request
     */
    public function handle($image, $options)
    {
        $options = array_merge($this->defaults, $options);

        return $image->insert($options['source'], $options['position'], $options['x'], $options['y']);
    }
}
