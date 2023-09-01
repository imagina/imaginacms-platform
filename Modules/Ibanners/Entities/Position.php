<?php

namespace Modules\Ibanners\Entities;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $fillable = [
        'name',
        'system_name',
        'active',
        'show_as_popup',
    ];

    protected $table = 'ibanners__positions';

    public function Banners()
    {
        return $this->hasMany(Banner::class)->with('translations')->orderBy('order', 'asc');
    }
}
