<?php

namespace Modules\Media\Image;
use \Intervention\Image\Image;
interface ImageHandlerInterface
{
    /**
     * Handle the image manipulation request
     *
     * @param  \Intervention\Image\Image  $image
     * @param  array  $options
     * @return \Intervention\Image\Image
     */
    public function handle(Image $image, array $options): Image;
}
