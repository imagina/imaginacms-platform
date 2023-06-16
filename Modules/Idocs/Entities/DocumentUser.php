<?php

namespace Modules\Idocs\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Modules\Core\Traits\NamespacedEntity;

class DocumentUser extends Model
{
    use  NamespacedEntity;

    protected $table = 'idocs__document_user';

    protected $fillable = [
        'document_id',
        'user_id',
        'key',
        'downloaded',
    ];

    public function setKeyAttribute($value)
    {
        $key = Str::random(48);

        $this->attributes['key'] = $key;
    }
}
