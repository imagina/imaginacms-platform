<?php

namespace Modules\Isite\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;
use Nwidart\Modules\Module;

class ConfigsApiController extends BaseApiController
{
    private $module;

    public function __construct()
    {
        $this->module = app('modules');
    }

    //Return fields
    public function index(Request $request)
    {
        try {
            $params = $this->getParamsRequest($request); //Get Parameters from URL.
            $enabledModules = $this->module->allEnabled(); //Get all modules
            $configName = $params->filter->configName ?? false; //Get config name filter
            $configNameByModule = $params->filter->configNameByModule ?? false; //Get config name by module filter

            //Get all configs
            if (! $configName && ! $configNameByModule) {
                $response = config('asgard');
            }

            //Get config by name
            if ($configName && strlen($configName)) {
                $configNameExplode = explode('.', $configName);
                $response = config('asgard.'.strtolower(array_shift($configNameExplode)).'.'.implode('.', $configNameExplode));
            }

            //Get config by name to each module
            if (isset($configNameByModule) && strlen($configNameByModule)) {
                $response = [];
                foreach (array_keys($enabledModules) as $moduleName) {
                    $response[$moduleName] = config('asgard.'.strtolower($moduleName).'.'.$configNameByModule);
                }
            }

            //Validate Response
            if ($response == null) {
                throw new \Exception('Item not found', 204);
            }

            //Response data
            $response = ['data' => $this->translateLabels($response)];
        } catch (\Exception $e) {
            $status = $this->getStatusError($e->getCode());
            $response = ['errors' => $e->getMessage()];
        }

        //Return response
        return response()->json($response, $status ?? 200);
    }

    //Recursive Translate labels
    public function translateLabels($data)
    {
        if (is_array($data)) {
            foreach ($data as $key => &$item) {
                if (is_string($item)) {
                    $item = trans($item);
                } elseif (is_array($item)) {
                    $item = $this->translateLabels($item);
                }
            }
        }

        return $data;
    }

    /** Return the modules information */
    public function modulesInfo(Request $request)
    {
        try {
            $params = $this->getParamsRequest($request); //Get Parameters from URL.
            $enabledModules = $this->module->allEnabled(); //Get all modules
            $modulesInfo = []; //Instance module info
            $tmpId = 1; //Instance Id

            //Instance module information
            foreach (array_keys($enabledModules) as $key => $moduleName) {
                $modulesInfo[$moduleName] = (object) [
                    'id' => $tmpId,
                    'parentId' => 0,
                    'name' => $moduleName,
                    'path' => "Modules\\{$moduleName}",
                    'entities' => [],
                ];
                //Increment UID
                $tmpId += 1;
            }

            //Get entities by module
            foreach (array_keys($enabledModules) as $keyModule => $moduleName) {
                $allFiles = \File::glob(base_path("Modules/{$moduleName}/Entities/*.php"));
                foreach ($allFiles as $keyEntity => $entity) {
                    $modulesInfo[$moduleName]->entities[] = (object) [
                        'id' => $tmpId,
                        'parentId' => $modulesInfo[$moduleName]->id,
                        'name' => pathinfo($entity, PATHINFO_FILENAME),
                        'path' => str_replace('/', '\\', str_replace('.php', '', explode('icms/', $entity)[1])),
                    ];
                    //Increment UID
                    $tmpId += 1;
                }
            }

            //Order data to select if request as filter
            if (isset($params->filter->asSelect) && $params->filter->asSelect) {
                $modulesInfoAsSelect = [];
                foreach (array_keys($enabledModules) as $moduleName) {
                    $modulesInfoAsSelect[] = $modulesInfo[$moduleName];
                    $modulesInfoAsSelect = array_merge($modulesInfoAsSelect, $modulesInfo[$moduleName]->entities);
                }
                //Clear data
                foreach ($modulesInfoAsSelect as $item) {
                    if (isset($item->entities)) {
                        unset($item->entities);
                    }
                }
                //Replace module info response
                $modulesInfo = $modulesInfoAsSelect;
            }

            //Response data
            $response = ['data' => $modulesInfo];
        } catch (\Exception $e) {
            $status = $this->getStatusError($e->getCode());
            $response = ['errors' => $e->getMessage()];
        }

        //Return response
        return response()->json($response, $status ?? 200);
    }
}
