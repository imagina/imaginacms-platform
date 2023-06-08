<?php

namespace Modules\Iappointment\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Icrud\Traits\hasEventsWithBindings;
use Modules\Iforms\Support\Traits\Formeable;
use Modules\Media\Support\Traits\MediaRelation;

use Modules\Core\Support\Traits\AuditTrait;

class Category extends Model
{
    use Translatable, MediaRelation, Formeable, hasEventsWithBindings, AuditTrait;

    protected $table = 'iappointment__categories';
    public $translatedAttributes = [
        'title',
        'slug',
        'status',
        'description'
    ];
    protected $fillable = [
        'parent_id',
        'options'
    ];
    protected $casts = [
        'options' => 'array'
    ];

    public function getOptionsAttribute($value)
    {
        return json_decode($value);
    }

    public function setOptionsAttribute($value)
    {
        $this->attributes['options'] = json_encode($value);
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'category_id');
    }

    public function getUrlAttribute(){
        $locale = \LaravelLocalization::setLocale() ?: \App::getLocale();
        return route($locale.'.appointment.category.show', [$this->id]);
    }

}
