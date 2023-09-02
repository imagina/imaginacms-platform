<?php

namespace Modules\Media\Image\Intervention\Manipulations;

use Modules\Media\Image\ImageHandlerInterface;

class LimitColors implements ImageHandlerInterface
{
    private $defaults = [
        'count' => 255,
        'matte' => null,
    ];

    /**
     * Handle the image manipulation request
     */
    public function handle($image, $options)
    {
        $options = array_merge($this->defaults, $options);

        return $image->limitColors($options['count'], $options['matte']);
    }
}
