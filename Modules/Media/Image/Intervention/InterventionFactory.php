<?php

namespace Modules\Media\Image\Intervention;

use Modules\Media\Image\ImageHandlerInterface;
use Modules\Media\Image\ImageFactoryInterface;
use Modules\Media\Image\ImageHandlerInterface;

class InterventionFactory implements ImageFactoryInterface
{
<<<<<<< HEAD
    public function make(string $manipulation): ImageHandlerInterface
=======
    public function make($manipulation)
>>>>>>> shift-93023
    {
        $class = 'Modules\\Media\\Image\\Intervention\\Manipulations\\'.ucfirst($manipulation);

        return new $class();
    }
}
