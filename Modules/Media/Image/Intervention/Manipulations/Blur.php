<?php

namespace Modules\Media\Image\Intervention\Manipulations;

use Modules\Media\Image\ImageHandlerInterface;

class Blur implements ImageHandlerInterface
{
    private $defaults = [
        'amount' => 1,
    ];

    /**
     * Handle the image manipulation request
     */
    public function handle($image, $options)
    {
        $options = array_merge($this->defaults, $options);

        return $image->blur($options['amount']);
    }
}
