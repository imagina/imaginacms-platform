<?php

namespace Modules\Media\Image\Intervention\Manipulations;

use Modules\Media\Image\ImageHandlerInterface;

class Heighten implements ImageHandlerInterface
{
    private $defaults = [
        'height' => 0,
    ];

    /**
     * Handle the image manipulation request
     */
    public function handle($image, $options)
    {
        $options = array_merge($this->defaults, $options);

        $callback = isset($options['callback']) ? $options['callback'] : null;

        return $image->heighten($options['height'], $callback);
    }
}
