<?php

namespace Modules\Media\Image\Intervention\Manipulations;

use Intervention\Image\Image;
use Modules\Media\Image\ImageHandlerInterface;

class Trim implements ImageHandlerInterface
{
    private $defaults = [
        'base' => 'top-left',
        'away' => ['top', 'bottom', 'left', 'right'],
        'tolerance' => 0,
        'feather' => 0,
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

        return $image->trim($options['base'], $options['away'], $options['tolerance'], $options['feather']);
    }
}
