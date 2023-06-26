<?php

namespace Modules\Media\Image\Intervention\Manipulations;

use Intervention\Image\Image;
use Modules\Media\Image\ImageHandlerInterface;

class Colorize implements ImageHandlerInterface
{
    private $defaults = [
        'red' => 100,
        'green' => 100,
        'blue' => 100,
    ];

    /**
     * Handle the image manipulation request
     *
     * @param  \Intervention\Image\Image  $image
     * @param  array  $options
     * @return \Intervention\Image\Image
     */
    public function handle(Image $image, array $options): Image
    {
        $options = array_merge($this->defaults, $options);

        return $image->colorize($options['red'], $options['green'], $options['blue']);
    }
}
