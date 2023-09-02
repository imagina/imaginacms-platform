<?php

namespace Modules\Media\Image\Intervention\Manipulations;

use Modules\Media\Image\ImageHandlerInterface;

class Opacity implements ImageHandlerInterface
{
    private $defaults = [
        'transparency' => 50,
    ];

    /**
     * Handle the image manipulation request
     */
    public function handle($image, $options)
    {
        $options = array_merge($this->defaults, $options);

        return $image->opacity($options['transparency']);
    }
}
