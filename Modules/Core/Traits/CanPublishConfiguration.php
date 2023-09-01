<?php

namespace Modules\Core\Traits;

trait CanPublishConfiguration
{
    /**
     * Publish the given configuration file name (without extension) and the given module
     */
    public function publishConfig(string $module, string $fileName)
    {
        if (app()->environment() === 'testing') {
            return;
        }

        $this->mergeConfigFrom($this->getModuleConfigFilePath($module, $fileName), strtolower("asgard.$module.$fileName"));
        $this->publishes([
            $this->getModuleConfigFilePath($module, $fileName) => config_path(strtolower("asgard/$module/$fileName").'.php'),
        ], 'config');
    }

    /**
     * Get path of the give file name in the given module
     */
    private function getModuleConfigFilePath(string $module, string $file): string
    {
        return $this->getModulePath($module)."/Config/$file.php";
    }

    private function getModulePath($module): string
    {
        return base_path('Modules'.DIRECTORY_SEPARATOR.ucfirst($module));
    }
}
