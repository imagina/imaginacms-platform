<?php

namespace Modules\Isite\Entities;

use Modules\Core\Icrud\Entities\CrudModel;

class Typeable extends CrudModel
{
    protected $table = 'isite__typeables';

    public $transformer = 'Modules\Isite\Transformers\TypeableTransformer';

    public $repository = 'Modules\Isite\Repositories\TypeableRepository';

    public $requestValidation = [
        'create' => 'Modules\Isite\Http\Requests\CreateTypeableRequest',
        'update' => 'Modules\Isite\Http\Requests\UpdateTypeableRequest',
    ];

    protected $fillable = [
        'typeable_type',
        'typeable_id',
        'layout_path',
        'layout_id',
    ];

    public function typeable()
    {
        return $this->morphTo();
    }

    public function layout()
    {
        return $this->belongsTo(Layout::class);
    }
}
