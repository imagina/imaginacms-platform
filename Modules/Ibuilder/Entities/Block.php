<?php

namespace Modules\Ibuilder\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Modules\Core\Icrud\Entities\CrudModel;
use Modules\Ifillable\Traits\isFillable;
use Modules\Media\Support\Traits\MediaRelation;

class Block extends CrudModel
{
    public $forceDeleting = true;

    use Translatable, MediaRelation, isFillable;

    protected $table = 'ibuilder__blocks';

    public $transformer = 'Modules\Ibuilder\Transformers\BlockTransformer';

    public $repository = 'Modules\Ibuilder\Repositories\BlockRepository';

    public $requestValidation = [
        'create' => 'Modules\Ibuilder\Http\Requests\CreateBlockRequest',
        'update' => 'Modules\Ibuilder\Http\Requests\UpdateBlockRequest',
    ];

    //Instance external/internal events to dispatch with extraData
    public $dispatchesEventsWithBindings = [
        //eg. ['path' => 'path/module/event', 'extraData' => [/*...optional*/]]
        'created' => [],
        'creating' => [],
        'updated' => [],
        'updating' => [],
        'deleting' => [],
        'deleted' => [],
    ];

    public $translatedAttributes = ['internal_title'];

    protected $fillable = ['system_name', 'status', 'component', 'entity', 'attributes', 'mobile_attributes'];

    protected $casts = ['component' => 'array', 'entity' => 'array', 'attributes' => AsArrayObject::class];
}
