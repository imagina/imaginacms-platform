<?php

namespace Modules\Ibooking\Entities;

use Illuminate\Database\Eloquent\Model;

class ReservationTranslation extends Model
{
    public $timestamps = false;

    protected $fillable = [];

    protected $table = 'ibooking__reservation_translations';
}
