<?php

namespace Modules\Setting\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Modules\Media\Support\Traits\MediaRelation;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class Setting extends Model
{
    use Translatable, MediaRelation, BelongsToTenant;

    public $translatedAttributes = ['value', 'description'];

    protected $fillable = ['name', 'value', 'description', 'isTranslatable', 'plainValue', 'organization_id'];

    protected $table = 'setting__settings';

    public function isMedia(): bool
    {
        $value = json_decode($this->plainValue, true);

        return is_array($value) && (isset($value['medias_single']) || isset($value['medias_multi']));
    }

    public function ownHasTranslation($locale)
    {
        return \Cache::store(config('cache.default'))->tags('setting.settings')->remember('own_has_translation_setting_'.$this->id.'_'.$locale, 60, function () use ($locale) {
            return $this->hasTranslation($locale);
        });
    }

    public function getValueByLocale($locale)
    {
        return \Cache::store(config('cache.default'))->tags('setting.settings')->remember('translate_by_locale_setting_'.$this->id.'_'.$locale, 60, function () use ($locale) {
            return $this->translate($locale)->value;
        });
    }
}
