<?php

namespace Modules\Media\Image\Intervention\Manipulations;

use Intervention\Image\Image;
use Modules\Media\Image\ImageHandlerInterface;

class Contrast implements ImageHandlerInterface
{
    private $defaults = [
        'level' => 0,
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

        return $image->contrast($options['level']);
    }
}
