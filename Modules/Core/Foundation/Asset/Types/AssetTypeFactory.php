<?php

namespace Modules\Core\Foundation\Asset\Types;

class AssetTypeFactory
{
    /**
     *
     * @throws \InvalidArgumentException
     */
    public function make($asset)
    {
        $typeClass = 'Modules\Core\Foundation\Asset\Types\\'.ucfirst(key($asset)).'Asset';

        if (class_exists($typeClass) === false) {
            throw new \InvalidArgumentException("Asset Type Class [$typeClass] not found");
        }

        return new $typeClass($asset);
    }
}
