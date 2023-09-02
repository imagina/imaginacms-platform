<?php

namespace Modules\Media\Image\Intervention\Manipulations;

use Modules\Media\Image\ImageHandlerInterface;

class Sharpen implements ImageHandlerInterface
{
    private $defaults = [
        'amount' => 10,
    ];

    /**
     * Handle the image manipulation request
     */
    public function handle($image, $options)
    {
        $options = array_merge($this->defaults, $options);

        return $image->sharpen($options['amount']);
    }
}
