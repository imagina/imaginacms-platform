<?php

namespace Modules\Requestable\Entities;

use Modules\Core\Icrud\Entities\CrudModel;
use Modules\User\Entities\Sentinel\User;

class StatusHistory extends CrudModel
{
    protected $table = 'requestable__status_history';

    public $transformer = 'Modules\Requestable\Transformers\StatusHistoryTransformer';

    public $repository = 'Modules\Requestable\Repositories\StatusHistoryRepository';

    public $requestValidation = [
        'create' => 'Modules\Requestable\Http\Requests\CreateStatusHistoryRequest',
        'update' => 'Modules\Requestable\Http\Requests\UpdateStatusHistoryRequest',
    ];

    protected $fillable = [
        'requestable_id',
        'status_id',
        'comment',
    ];

    public function requestable()
    {
        return $this->belongsTo(Requestable::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function createdByUser()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
