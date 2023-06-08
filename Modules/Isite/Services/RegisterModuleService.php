<?php


namespace Modules\Isite\Services;


class RegisterModuleService
{
  
  public function registerModule(string $moduleAlias, array $columns, $priority = 1){
  
    $moduleRepository = app("Modules\Isite\Repositories\ModuleRepository");
  
    $params = [
      "filter" => [
        "field" => "alias",
      ],
      "include" => [],
      "fields" => [],
    ];
    $module = $moduleRepository->getItem($moduleAlias, json_decode(json_encode($params)));
  
    //creating the module in database if not exist
    if (!isset($module->id)) {
      $module = $moduleRepository->create([
        "alias" => $moduleAlias,
        "es" => [
          "name" => trans("$moduleAlias::$moduleAlias.name", [], "es"),
        ],
        "en" => [
          "name" => trans("$moduleAlias::$moduleAlias.name", [], "en"),
        ],
        "enabled" => true,
        "priority" => $priority,
      ]);
    }
  
    //setting the other columns validating if there are any change to fill it
    foreach ($columns as $column){
    
      $config = config("asgard.$moduleAlias.".$column["config"]) ?? [];
      $moduleValue = $module->{$column["name"]} ?? [];
      //setting the module column name if the current config have diff
    
      if ((json_encode($config) != json_encode($moduleValue))) {
        $module->{$column["name"]} = array_replace_recursive($config,$moduleValue);
      }
    
    }
  
    $module->save();
    
  }
  
}