<?php

namespace Modules\Isite\Entities;

use Astrotomic\Translatable\Translatable;
use Modules\Core\Icrud\Entities\CrudModel;
use Modules\Isite\Traits\WithProduct;
use Modules\Media\Support\Traits\MediaRelation;

class Layout extends CrudModel
{
    use Translatable,MediaRelation, WithProduct;

    protected $table = 'isite__layouts';

    public $transformer = 'Modules\Isite\Transformers\LayoutTransformer';

    public $repository = 'Modules\Isite\Repositories\LayoutRepository';

    public $requestValidation = [
        'create' => 'Modules\Isite\Http\Requests\CreateLayoutRequest',
        'update' => 'Modules\Isite\Http\Requests\UpdateLayoutRequest',
    ];

    public $translatedAttributes = [
        'title',
    ];

    protected $fillable = [
        'system_name',
        'module_name',
        'entity_name',
        'entity_type',
        'path',
        'status',
        'record_type',
        'is_internal',
    ];
}
