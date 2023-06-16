<?php

namespace Modules\Isite\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Session\Store;
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;
use Modules\Isite\Transformers\SettingTransformer;
use Modules\Setting\Contracts\Setting;
use Modules\Setting\Repositories\SettingRepository;
use Nwidart\Modules\Module;

class SettingApiController extends BaseApiController
{
    /**
     * @var PaypalconfigRepository
     */
    private $settings;

    /**
     * @var Module
     */
    private $module;

    /**
     * @var Store
     */
    private $session;

    private $setting;

    public function __construct(SettingRepository $settings, Store $session, Setting $setting)
    {
        $this->settings = $settings;
        $this->module = app('modules');
        $this->session = $session;
        $this->setting = $setting;
    }

    /**
     * GET ITEMS
     *
     * @return mixed
     */
    public function index(Request $request)
    {
        try {
            //Get Parameters from URL.
            $params = $this->getParamsRequest($request);

            $modulesWithSettings = $this->settings->moduleSettings($this->module->allEnabled());

            $dbSettings = [];
            $translatableSettings = [];
            $plainSettings = [];

            // fetching translatable, plain, and DB setting by each module enabled with settings
            foreach ($modulesWithSettings as $key => $module) {
                $translatableSettings[$key] = $this->settings->translatableModuleSettings($key);
                $plainSettings[$key] = $this->settings->plainModuleSettings($key);
                $dbSettings[$key] = $this->settings->savedModuleSettings($key);
            }
            /*=== SETTINGS ===*/
            $assignedSettings = [];

            // merging translatable and plain settings
            $mergedSettings = array_merge_recursive($translatableSettings, $plainSettings);

            $response = ['data' => $this->transformSettings($mergedSettings, $dbSettings, $assignedSettings)];
        } catch (\Exception $e) {
            $status = $this->getStatusError($e->getCode());
            $response = ['errors' => $e->getMessage()];
        }

        //Return response
        return response()->json($response, $status ?? 200);
    }

    /**
     * GET A ITEM
     *
     * @return mixed
     */
    public function show($criteria, Request $request)
    {
        try {
            //Get Parameters from URL.
            $params = $this->getParamsRequest($request);

            $module = $this->module->find($criteria);

            //Break if no found item
            if (! $module) {
                throw new \Exception('Item not found', 404);
            }

            $this->session->put('module', $module->getLowerName());
            $dbSettings = $this->settings->findByModule($module->getLowerName());
            //Response
            $response = ['data' => SettingTransformer::collection($dbSettings)];
        } catch (\Exception $e) {
            $status = $this->getStatusError($e->getCode());
            $response = ['errors' => $e->getMessage()];
        }

        //Return response
        return response()->json($response, $status ?? 200);
    }

    /**
     * UPDATE ITEM
     *
     * @param $criteria
     * @return mixed
     */
    public function createOrUpdate(Request $request)
    {
        \DB::beginTransaction(); //DB Transaction
        try {
            //Get Parameters from URL.
            $params = $this->getParamsRequest($request);
            //Get data
            $data = $request->input('attributes');

            //Validate settings can manage
            if (isset($params->settings['assignedSettings']) && count($params->settings['assignedSettings'])) {
                foreach ($data as $settingName => $settingValue) {
                    if (! in_array($settingName, $params->settings['assignedSettings'])) {
                        unset($data[$settingName]);
                    }
                }
            }

            $this->settings->createOrUpdate($data);

            //Response
            $response = ['data' => 'Item Updated'];
            \DB::commit(); //Commit to DataBase
        } catch (\Exception $e) {
            \DB::rollback(); //Rollback to Data Base
            $status = $this->getStatusError($e->getCode());
            $response = ['errors' => $e->getMessage()];
        }

        //Return response
        return response()->json($response, $status ?? 200);
    }

    public function transformSettings(&$mergedSettings, $dbSettings, $assignedSettings)
    {
        foreach ($mergedSettings as $keyModule => &$module) {
            foreach ($module as $keySetting => &$setting) {
                $settingName = strtolower($keyModule).'::'.$keySetting; //Setting name
                $dbSetting = $dbSettings[$keyModule][$settingName] ?? false; //DB setting value
        //Get available locales
                $locales = json_decode($dbSettings['Core']['core::locales']->plainValue ?? json_encode([locale()]));

                //Transform settings
                if (empty($assignedSettings) || in_array($settingName, $assignedSettings)) {
                    //Set setting value from DB
                    if ($dbSetting) {
                        $setting = array_merge($setting, $dbSetting->toArray());
                    }
                    //Get default value
                    $defaultValue = ! isset($setting['default']) ? null :
                      ($this->isJson($setting['default']) ? json_decode($setting['default']) : $setting['default']);
                    //Get plain value
                    $plainValue = ! isset($setting['plainValue']) ? null :
                      ($this->isJson($setting['plainValue']) ? json_decode($setting['plainValue']) : $setting['plainValue']);
                    //Validate default values
                    $setting = array_merge($setting, [
                        'name' => $settingName,
                        'description' => isset($setting['description']) ? trans($setting['description']) : '',
                        'isTranslatable' => $setting['translatable'] ?? false,
                        'plainValue' => $plainValue ?? $defaultValue,
                        'value' => ! is_null($plainValue) ? $plainValue : ($setting['value'] ?? $defaultValue ?? null),
                    ]);
                    //Get media path
                    if (is_object($setting['value']) && isset($setting['value']->medias_single)) {
                        //Get media
                        $media = $dbSetting ? $dbSetting->files()->where('zone', $settingName)->first() : null;
                        //Set media value
                        $setting['media'] = [
                            'mimeType' => ($media === null) ? 'image/jpeg' : $media->mimetype,
                            'path' => ($media === null) ? url('modules/isite/img/defaultLogo.jpg') : $media->path_string,
                        ];
                    }
                    //Validate translations
                    if ($setting['isTranslatable'] && ! isset($setting['translations'])) {
                        $setting['translations'] = []; //Default value
                        //Set translations
                        foreach ($locales as $locale) {
                            $setting['translations'][] = ['locale' => $locale, 'value' => $setting['value']];
                        }
                    }
                } else {
                    unset($module[$keySetting]);
                }
            }

            if (empty($module)) {
                unset($mergedSettings[$keyModule]);
            }
        }

        return $mergedSettings;
    }

    public function isJson($string)
    {
        return ((is_string($string) &&
          (is_object(json_decode($string)) ||
            is_array(json_decode($string))))) ? true : false;
    }
}
