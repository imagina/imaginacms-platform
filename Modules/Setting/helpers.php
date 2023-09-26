<?php

if (! function_exists('setting')) {
    function setting($name, $locale = null, $default = null, $central = false)
    {
      try {
        if(!app('asgard.isInstalled')) return $default;
        return app('setting.settings')->get($name, $locale, $default, $central);
      }catch (\Exception $e){
      
      }
      return null;
      
    }
}

if (! function_exists('getSettingsFormat')) {
    //Transform settings-fields to setting format
    function getSettingsFormat($settingsFields = [], $moduleName = false)
    {
        if (! $moduleName) {
            return [];
        }
        $response = []; //Default response

        //Create settings
        foreach (json_decode(json_encode($settingsFields)) as $field) {
            $settingName = str_replace("{$moduleName}::", '', ($field->fakeFieldName ?? $field->name));
            //Create setting
            if (! isset($response[$settingName])) {
                $response[$settingName] = [
                    'onlySuperAdmin' => $field->onlySuperAdmin ?? false,
                    'description' => isset($field->children) ? ($field->group ?? $field->label ?? '') :
                      (isset($field->props) ? ($field->props->label ?? '') : ''),
                    'default' => isset($field->children) || isset($field->fakeFieldName) ? [] : ($field->value ?? null),
                    'view' => 'settingField',
                    'translatable' => isset($field->isTranslatable) && $field->isTranslatable ? true : false,
                ];
            } else {
                //Validate others fields if setting is translatable
                if (isset($field->isTranslatable) && $field->isTranslatable) {
                    $response[$settingName]['translatable'] = true;
                }
            }

            //Add fake values
            if (isset($field->fakeFieldName)) {
                $response[$settingName]['default'][$field->name] = $field->value;
            }

            //Add child values
            if (isset($field->children)) {
                foreach ($field->children as $childField) {
                    //Add fake child field value
                    if (isset($childField->fakeFieldName)) {
                        //Create child fake field
                        if (! isset($response[$settingName]['default'][$childField->fakeFieldName])) {
                            $response[$settingName]['default'][$childField->fakeFieldName] = [];
                        }
                        //Add child fake field
                        $response[$settingName]['default'][$childField->fakeFieldName][$childField->name] = $childField->value;
                    } else {
                        $response[$settingName]['default'][$childField->name] = $childField->value;
                    }
                }
            }
        }

        //Code default values
        foreach ($response as &$item) {
            if (is_array($item['default'])) {
                $item['default'] = json_encode($item['default']);
            }
        }

        //Response
        return $response;
    }
}
