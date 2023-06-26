<?php

namespace Modules\Setting\Support;

use Modules\Setting\Contracts\Setting;
use Modules\Setting\Repositories\SettingRepository;

class Settings implements Setting
{
    /**
     * @var SettingRepository
     */
    private $setting;

    public function __construct(SettingRepository $setting)
    {
        $this->setting = $setting;
    }

    /**
     * Getting the setting
     *
     * @param  string  $name
     * @param  string  $locale
     * @param  string  $default
     * @return mixed
     */
    public function get(string $name, string $locale = null, string $default = null, $central = false)
    {
        $defaultFromConfig = $this->getDefaultFromConfigFor($name);

        //tracking if the env DB_DATABASE not exist to avoid the query in the DB
        if (env('DB_DATABASE', 'forge') == 'forge') {
            return is_null($default) ? $defaultFromConfig : $default;
        }

        $setting = $this->setting->findByName($name, $central);

        if (empty($setting)) {
            return is_null($default) ? $defaultFromConfig : $default;
        }

        if ($setting->isMedia() && $media = $setting->files->first()) {
            if ($media->isImage()) {
                $mediaFiles = $setting->mediaFiles();

                return $mediaFiles->{$setting->name}->extraLargeThumb ?? $mediaFiles->{'setting::mainimage'}->extraLargeThumb ?? $media->path;
            }

            return $media->path;
        }

        if ($setting->isTranslatable) {
            if ($setting->ownHasTranslation($locale)) {
                $value = trim($setting->getValueByLocale($locale));

                return $value === '' ? $defaultFromConfig : $value;
            }
        } else {
            return trim($setting->plainValue) === '' ? $defaultFromConfig : $setting->plainValue;
        }

        return $defaultFromConfig;
    }

    /**
     * Determine if the given configuration value exists.
     *
     * @param  string  $name
     * @return bool
     */
    public function has(string $name): bool
    {
        $default = microtime(true);

        return $this->get($name, null, $default) !== $default;
    }

    /**
     * Set a given configuration value.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return \Modules\Setting\Entities\Setting
     */
    public function set(string $key, $value): \Modules\Setting\Entities\Setting
    {
        return $this->setting->create([
            'name' => $key,
            'plainValue' => $value,
        ]);
    }

    /**
     * Get the default value from the settings configuration file,
     * for the given setting name.
     *
     * @param  string  $name
     * @return string
     */
    private function getDefaultFromConfigFor(string $name): string
    {
        [$module, $settingName] = explode('::', $name);

        return config("asgard.$module.settings.$settingName.default", '');
    }
}
