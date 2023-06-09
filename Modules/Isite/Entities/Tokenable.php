<?php

namespace Modules\Isite\Entities;

use Modules\Core\Icrud\Entities\CrudModel;

class Tokenable extends CrudModel
{
    protected $table = 'isite__tokenables';

    public $transformer = 'Modules\Isite\Transformers\TokenableTransformer';

    public $repository = 'Modules\Isite\Repositories\TokenableRepository';

    public $requestValidation = [
        'create' => 'Modules\Isite\Http\Requests\CreateTokenableRequest',
        'update' => 'Modules\Isite\Http\Requests\UpdateTokenableRequest',
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

    protected $fillable = [
        'token',
        'expires_at',
        'entity_id',
        'entity_type',
        'uses',
        'used',
    ];

    public function selfRestore()
    {
        return $this->create($this->attributes);
    }
}
