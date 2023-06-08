<?php

namespace Modules\Ievent\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class RecurrenceDay extends Model
{


    protected $table = 'ievent__recurrence_days';

    protected $fillable = [
      'days',
      'hour',
      'recurrence_id',
    ];


  public function recurrence(){
    $this->belognsTo(Recurrence::class);
  }
}
