<?php

namespace Modules\Media\Image\Intervention\Manipulations;

use Intervention\Image\Image;
use Modules\Media\Image\ImageHandlerInterface;

class Greyscale implements ImageHandlerInterface
{
    /**
     * Handle the image manipulation request
     *
     * @param  \Intervention\Image\Image  $image
     * @param  array  $options
     * @return \Intervention\Image\Image
     */
    public function handle(Image $image, array $options): Image
    {
        return $image->greyscale();
    }
}
