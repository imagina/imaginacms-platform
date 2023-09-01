<?php

namespace Modules\Notification\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    use Translatable;

    protected $table = 'notification__providers';

    public $translatedAttributes = [
        'description',
    ];

    protected $fillable = [
        'name',
        'status',
        'system_name',
        'options',
        'default',
        'type',
        'fields',
    ];

    protected $fakeColumns = ['options', 'fields'];

    protected $casts = [
        'options' => 'array',
        'fields' => 'array',
    ];

    /**
     * @return mixed
     */
    public function rules()
    {
        return $this->hasMany(Rule::class);
    }

    public function getOptionsAttribute($value)
    {
        return json_decode($value);
    }

    public function setOptionsAttribute($value)
    {
        $this->attributes['options'] = json_encode($value);
    }

    public function getFieldsAttribute($value)
    {
        return json_decode($value);
    }

    public function setFieldsAttribute($value)
    {
        $this->attributes['fields'] = json_encode($value);
    }
}
