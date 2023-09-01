<?php

namespace Modules\Core\Traits;

trait CanGetSidebarClassForModule
{
    public function getSidebarClassForModule(string $module, string $default): string
    {
        if ($this->hasCustomSidebar($module)) {
            $class = config("asgard.{$module}.config.custom-sidebar");
            if (class_exists($class) === false) {
                return $default;
            }

            return $class;
        }

        return $default;
    }

    private function hasCustomSidebar($module)
    {
        $config = config("asgard.{$module}.config.custom-sidebar");

        return $config !== null;
    }
}
