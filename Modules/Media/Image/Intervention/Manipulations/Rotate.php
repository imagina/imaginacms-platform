<?php

namespace Modules\Media\Image\Intervention\Manipulations;

use Modules\Media\Image\ImageHandlerInterface;

class Rotate implements ImageHandlerInterface
{
    private $defaults = [
        'angle' => 45,
        'bgcolor' => '#000000',
    ];

    /**
     * Handle the image manipulation request
     */
    public function handle($image, $options)
    {
        $options = array_merge($this->defaults, $options);

        return $image->rotate($options['angle'], $options['bgcolor']);
    }
}
