<?php

namespace Modules\Ibooking\Entities;

use Illuminate\Database\Eloquent\Model;

class ServiceTranslation extends Model
{
    public $timestamps = false;

    protected $fillable = ['title', 'description', 'slug'];

    protected $table = 'ibooking__service_translations';
}
