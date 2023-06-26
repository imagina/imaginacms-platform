<?php

namespace Modules\Media\Image\Intervention;

use Modules\Media\Image\ImageFactoryInterface;
use Modules\Media\Image\ImageHandlerInterface;

class InterventionFactory implements ImageFactoryInterface
{
    public function make(string $manipulation): ImageHandlerInterface
    {
        $class = 'Modules\\Media\\Image\\Intervention\\Manipulations\\'.ucfirst($manipulation);

        return new $class();
    }
}
