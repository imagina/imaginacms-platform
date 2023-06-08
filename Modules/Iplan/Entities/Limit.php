<?php

namespace Modules\Iplan\Entities;

use Illuminate\Database\Eloquent\Model;

class Limit extends Model
{

  protected $table = 'iplan__limits';

  protected $fillable = [
    "name",
    "entity",
    "quantity",
    "attribute",
    "attribute_value",
    "plan_id",
  ];

    public function plans()
    {
        return $this->belongsToMany(Plan::class,'iplan__plan_limits');
    }

}
