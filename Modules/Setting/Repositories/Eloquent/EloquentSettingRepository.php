<?php

namespace Modules\Setting\Repositories\Eloquent;

use Illuminate\Support\Facades\Cache;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Modules\Setting\Entities\Setting;
use Modules\Setting\Events\SettingIsCreating;
use Modules\Setting\Events\SettingIsUpdating;
use Modules\Setting\Events\SettingWasCreated;
use Modules\Setting\Events\SettingWasUpdated;
use Modules\Setting\Repositories\SettingRepository;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class EloquentSettingRepository extends EloquentBaseRepository implements SettingRepository
{
  /**
   * Update a resource
   *
   * @return mixed
   */
  public function update($id, $data)
  {
  }

  /**
   * Return all settings, with the setting name as key
   */
  public function all()
  {
    $rawSettings = parent::all();

    $settings = [];
    foreach ($rawSettings as $setting) {
      $settings[$setting->name] = $setting;
    }

    return $settings;
  }

  /**
   * Create or update the settings
   *
   * @return mixed|void
   */
  public function createOrUpdate($settings)
  {
    $this->removeTokenKey($settings);
    $this->removeCache();

    foreach ($settings as $settingName => $settingValues) {
      // Check if media exists
      if ($settingName == 'medias_single') {
        // Get first key of values (Original settingName)
        foreach ($settingValues as $key => $value) {
          $normalisedValue = [$settingName => [$key => $value]];
          $settingName = $key;
          break;
        }
        $settingValues = $normalisedValue;
      }
      if ($setting = $this->findByName($settingName)) {
        $this->updateSetting($setting, $settingValues);

        continue;
      }
      $this->createForName($settingName, $settingValues);
    }
  }

  /**
   * Remove the token from the input array
   */
  private function removeTokenKey(&$settings)
  {
    unset($settings['_token']);
  }

  private function removeCache()
  {
    Cache::tags('setting.settings')->flush();
  }

  /**
   * Find a setting by its name
   *
   * @return mixed
   */
  public function findByName($settingName, $central = false, $organizationId = null)
  {
    $model = $this->model;

    $query = $model->where('name', $settingName)->with('files', 'files.translations', 'translations');

    if (config('tenancy.mode') == 'singleDatabase') {
      $entitiesWithCentralData = $this->get('isite::tenantWithCentralData', true);

      $entitiesWithCentralData = json_decode($entitiesWithCentralData->plainValue ?? '[]');
      $tenantWithCentralData = in_array('setting', $entitiesWithCentralData);

      if ($central) {
        $query->withoutTenancy()
          ->whereNull('organization_id');
      } elseif ($tenantWithCentralData && isset(tenant()->id)) {
        $query->withoutTenancy();
        $query->where(function ($query) use ($model) {
          $query->where($model->qualifyColumn(BelongsToTenant::$tenantIdColumn), tenant()->getTenantKey());
        });
      } elseif (!is_null($organizationId)) {
        $query->where('organization_id', $organizationId);
      }
    }

    return $query->first() ?? '';

  }

  /**
   * Create a setting with the given name
   */
  private function createForName($settingName, $settingValues)
  {
    event($event = new SettingIsCreating($settingName, $settingValues));

    $setting = new $this->model();
    $setting->name = $settingName;

    if ($this->isTranslatableSetting($settingName)) {
      $setting->isTranslatable = true;
      $this->setTranslatedAttributes($event->getSettingValues(), $setting);
    } else {
      $setting->isTranslatable = false;
      $setting->plainValue = $this->getSettingPlainValue($event->getSettingValues());
    }

    $setting->save();

    event(new SettingWasCreated($setting, $settingValues));

    return $setting;
  }

  /**
   * Update the given setting
   *
   * @param object setting
   */
  private function updateSetting($setting, $settingValues)
  {
    $name = $setting->name;
    event($event = new SettingIsUpdating($setting, $name, $settingValues));

    if ($this->isTranslatableSetting($name)) {
      $this->setTranslatedAttributes($event->getSettingValues(), $setting);
    } else {
      $setting->plainValue = $this->getSettingPlainValue($event->getSettingValues());
    }
    $setting->save();

    event(new SettingWasUpdated($setting, $settingValues));

    return $setting;
  }

  private function setTranslatedAttributes($settingValues, $setting)
  {
    foreach ($settingValues as $lang => $value) {
      $setting->translateOrNew($lang)->value = $value;
    }
  }

  /**
   * Return all modules that have settings
   * with its settings
   *
   * @param array|string $modules
   */
  public function moduleSettings($modules)
  {
    if (is_string($modules)) {
      return config('asgard.' . strtolower($modules) . '.settings');
    }

    $modulesWithSettings = [];
    foreach ($modules as $module) {
      if ($moduleSettings = config('asgard.' . strtolower($module->getName()) . '.settings')) {
        $modulesWithSettings[$module->getName()] = $moduleSettings;
      }
    }

    return $modulesWithSettings;
  }

  /**
   * Return the saved module settings
   *
   * @return mixed
   */
  public function savedModuleSettings($module)
  {
    $moduleSettings = [];
    foreach ($this->findByModule($module) as $setting) {
      $moduleSettings[$setting->name] = $setting;
    }

    return $moduleSettings;
  }

  /**
   * Find settings by module name
   *
   * @param string $module Module name
   * @return mixed
   */
  public function findByModule($module, $central = false)
  {
    $model = $this->model;

    return Cache::store(config('cache.default'))->tags('setting.settings' . (tenant()->id ?? ''))
      ->remember('module_settings_' . $module . $central . (tenant()->id ?? ''), 120,
        function () use ($model, $module, $central) {
          $query = $model->where('name', 'LIKE', $module . '::%');

          if (config('tenancy.mode') == 'singleDatabase') {
            $entitiesWithCentralData = Cache::store(config('cache.default'))
              ->remember('module_settings_tenantWithCentralData' . (tenant()->id ?? ''), 120, function () {
                return $this->get('isite::tenantWithCentralData', true);
              });
            $entitiesWithCentralData = json_decode($entitiesWithCentralData->plainValue ?? '[]');
            $tenantWithCentralData = in_array('setting', $entitiesWithCentralData);
            if ($central || !isset(tenant()->id)) {
              $query->withoutTenancy()
                ->whereNull('organization_id');
            } elseif ($tenantWithCentralData && isset(tenant()->id)) {
              $query->withoutTenancy();
              $query->where(function ($query) use ($model) {
                $query->where($model->qualifyColumn(BelongsToTenant::$tenantIdColumn), tenant()->getTenantKey())
                  ->orWhereNull($model->qualifyColumn(BelongsToTenant::$tenantIdColumn));
              });
            }
          }

          return $query->get();
        });
  }

  /**
   * Find the given setting name for the given module
   *
   * @return mixed
   */
  public function get($settingName, $central = false)
  {
    $query = $this->model->where('name', 'LIKE', "{$settingName}");

    //validate if the settings table already has the organization_id column to avoid error in the composer update
    if (\Schema::hasColumn('setting__settings', 'organization_id')) {
      if ($central) {
        $query->withoutTenancy()
          ->whereNull('organization_id');
      }
    }

    return $query->first();
  }

  /**
   * Return the translatable module settings
   *
   * @return mixed
   */
  public function translatableModuleSettings($module)
  {
    return array_filter($this->moduleSettings($module), function ($setting) {
      return isset($setting['translatable']) && $setting['translatable'] === true;
    });
  }

  /**
   * Return the non translatable module settings
   */
  public function plainModuleSettings($module)
  {
    return array_filter($this->moduleSettings($module), function ($setting) {
      return !isset($setting['translatable']) || $setting['translatable'] === false;
    });
  }

  /**
   * Return a setting name using dot notation: asgard.{module}.settings.{settingName}
   */
  private function getConfigSettingName($settingName)
  {
    [$module, $setting] = explode('::', $settingName);

    return "asgard.{$module}.settings.{$setting}";
  }

  /**
   * Check if the given setting name is translatable
   */
  private function isTranslatableSetting($settingName)
  {
    $configSettingName = $this->getConfigSettingName($settingName);

    $setting = config("$configSettingName");

    return isset($setting['translatable']) && $setting['translatable'] === true;
  }

  /**
   * Return the setting value(s). If values are ann array, json_encode them
   *
   * @param string|array $settingValues
   */
  private function getSettingPlainValue($settingValues)
  {
    if (is_array($settingValues)) {
      return json_encode($settingValues);
    }

    return $settingValues;
  }
}
