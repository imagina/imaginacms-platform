<?php

namespace Modules\Imeeting\Entities;

use Astrotomic\Translatable\Translatable;
use Modules\Core\Icrud\Entities\CrudModel;
use Modules\Media\Support\Traits\MediaRelation;

class Provider extends CrudModel
{
    use Translatable, MediaRelation;

    public $transformer = 'Modules\Imeeting\Transformers\ProviderTransformer';

    public $requestValidation = [
        'create' => 'Modules\Imeeting\Http\Requests\CreateProviderRequest',
        'update' => 'Modules\Imeeting\Http\Requests\UpdateProviderRequest',
    ];

    public $translatedAttributes = [
        'title',
        'description',
    ];

    protected $table = 'imeeting__providers';

    protected $fillable = [
        'status',
        'name',
        'options',
    ];

    protected $casts = [
        'options' => 'array',
    ];

    public function getOptionsAttribute($value)
    {
        return json_decode($value);
    }

    public function setOptionsAttribute($value)
    {
        $this->attributes['options'] = json_encode($value);
    }
}
