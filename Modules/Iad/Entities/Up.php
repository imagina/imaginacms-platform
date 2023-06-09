<?php

namespace Modules\Iad\Entities;

use Astrotomic\Translatable\Translatable;
use Modules\Core\Icrud\Entities\CrudModel;
use Modules\Isite\Traits\WithProduct;

class Up extends CrudModel
{
    use Translatable, WithProduct;

    public $transformer = 'Modules\Iad\Transformers\UpTransformer';

    public $entity = 'Modules\Iad\Entities\Up';

    public $repository = 'Modules\Iad\Repositories\UpRepository';

    public $requestValidation = [
        'create' => 'Modules\Iad\Http\Requests\CreateUpRequest',
        'update' => 'Modules\Iad\Http\Requests\UpdateUpRequest',
    ];

    protected $table = 'iad__ups';

    public $translatedAttributes = [
        'title',
        'description',
    ];

    protected $fillable = [
        'days_limit',
        'ups_daily',
        'status',
    ];
}
