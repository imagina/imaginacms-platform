<?php

namespace Modules\Ifillable\Entities;

use Astrotomic\Translatable\Translatable;
use Modules\Core\Icrud\Entities\CrudModel;

class Field extends CrudModel
{
    use Translatable;

    protected $table = 'ifillable__fields';

    public $transformer = 'Modules\Ifillable\Transformers\FieldTransformer';

    public $repository = 'Modules\Ifillable\Repositories\FieldRepository';

    public $requestValidation = [
        'create' => 'Modules\Ifillable\Http\Requests\CreateFieldRequest',
        'update' => 'Modules\Ifillable\Http\Requests\UpdateFieldRequest',
    ];

    public $translatedAttributes = [
        'value',
    ];

    protected $fillable = [
        'name',
        'type',
        'entity_id',
        'entity_type',
    ];

    /**
     * Get the parent schedulable model.
     */
    public function morphFillable()
    {
        return $this->morphTo();
    }
}
