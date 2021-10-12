<?php

namespace Modules\Iforms\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\User\Entities\Sentinel\User;
use Modules\Media\Support\Traits\MediaRelation;

class Lead extends Model
{
  use MediaRelation;
  
  protected $table = 'iforms__leads';
  
  protected $fillable = [
    'form_id',
    'assigned_to_id',
    'values'
  ];
  
  protected $casts = [
    'values' => 'array'
  ];
  
  public function form()
  {
    return $this->belongsTo(Form::class);
  }
  
  public function assignedTo()
  {
    return $this->belongsTo(User::class, 'assigned_to_id');
  }
}
