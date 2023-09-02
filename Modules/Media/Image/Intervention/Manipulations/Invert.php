<?php

namespace Modules\Media\Image\Intervention\Manipulations;

use Modules\Media\Image\ImageHandlerInterface;

class Invert implements ImageHandlerInterface
{
    /**
     * Handle the image manipulation request
     */
    public function handle($image, $options)
    {
        return $image->invert();
    }
}
