<?php

namespace Modules\Iplaces\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Laracasts\Presenter\PresentableTrait;
use Modules\Core\Support\Traits\AuditTrait;
use Modules\Core\Traits\NamespacedEntity;
use Modules\Iplaces\Presenters\ServicePresenter;
use Modules\Media\Support\Traits\MediaRelation;

class Service extends Model
{
    use Translatable,PresentableTrait, NamespacedEntity, MediaRelation, AuditTrait;

    protected $table = 'iplaces__services';

    public $translatedAttributes = ['title', 'description', 'slug', 'meta_title', 'meta_description', 'meta_keywords'];

    protected $fillable = ['title', 'description', 'slug', 'options', 'status', 'serv_type', 'meta_title', 'meta_description', 'meta_keywords'];

    protected $fakeColumns = ['options'];

    protected $presenter = ServicePresenter::class;

    protected $casts = [
        'options' => 'array',
    ];

    public function places()
    {
        return $this->belongsToMany(Place::class, 'iplaces__place_service');
    }

    protected function setSlugAttribute($value)
    {
        if (! empty($value)) {
            $this->attributes['slug'] = Str::slug($value, '-');
        } else {
            $this->attributes['slug'] = Str::slug($this->attributes['title'], '-');
        }
    }

    public function getMainImageAttribute()
    {
        $thumbnail = $this->files()->where('zone', 'mainimage')->first();
        if (! $thumbnail) {
            return [
                'mimeType' => 'image/jpeg',
                'path' => url('modules/iblog/img/post/default.jpg'),
            ];
        }

        return [
            'mimeType' => $thumbnail->mimetype,
            'path' => $thumbnail->path_string,
        ];
    }

    public function getUrlAttribute()
    {
        return url($this->slug);
    }

    public function getOptionsAttribute($value)
    {
        return json_decode(json_decode($value));
    }
/*
    public function scopeActive(Builder $query)
    {
        return $query->whereStatus(Status::ACTIVE);
    }


    public function scopeInactive(Builder $query)
    {
        return $query->whereStatus(Status::INACTIVE);
    }*/
}
