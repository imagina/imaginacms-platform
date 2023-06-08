<?php

namespace Modules\Ifollow\Entities;

use Astrotomic\Translatable\Translatable;
use Modules\Core\Icrud\Entities\CrudModel;

class Follower extends CrudModel
{
    protected $table = 'ifollow__followers';
    public $transformer = 'Modules\Ifollow\Transformers\FollowerTransformer';
    public $requestValidation = [
        'create' => 'Modules\Ifollow\Http\Requests\CreateFollowerRequest',
        'update' => 'Modules\Ifollow\Http\Requests\UpdateFollowerRequest',
        'delete' => 'Modules\Ifollow\Http\Requests\DeleteFollowerRequest',
      ];

    protected $fillable = [
        'follower_id',
        'followable_id',
        'followable_type',

    ];

    public function followable()
    {
        return $this->morphTo();
    }

    public function user(){
        $driver = config('asgard.user.config.driver');

        return $this->belongsTo("Modules\\User\\Entities\\{$driver}\\User","follower_id");
    }
}
