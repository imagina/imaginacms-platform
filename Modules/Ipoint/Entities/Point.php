<?php

namespace Modules\Ipoint\Entities;

use Modules\Core\Icrud\Entities\CrudModel;

class Point extends CrudModel
{
    protected $table = 'ipoint__points';

    public $transformer = 'Modules\Ipoint\Transformers\PointTransformer';

    public $requestValidation = [
        'create' => 'Modules\Ipoint\Http\Requests\CreatePointRequest',
        'update' => 'Modules\Ipoint\Http\Requests\UpdatePointRequest',
    ];

    protected $fillable = [
        'user_id',
        'pointable_id',
        'pointable_type',
        'description',
        'points',
    ];

    public function user()
    {
        $driver = config('asgard.user.config.driver');

        return $this->belongsTo("Modules\\User\\Entities\\{$driver}\\User");
    }
}
