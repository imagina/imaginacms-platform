<?php

namespace Modules\Idocs\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\PresentableTrait;
use Modules\Idocs\Presenters\DocumentPresenter;
use Modules\Core\Traits\NamespacedEntity;
use Modules\Iprofile\Entities\Department;
use Modules\Media\Entities\File;
use Modules\Media\Support\Traits\MediaRelation;
use Illuminate\Support\Str;

class DocumentUser extends Model
{
  use  NamespacedEntity;
  
  protected $table = 'idocs__document_user';
  protected $fillable = [
    'document_id',
    'user_id',
    'key',
    'downloaded'
  ];
  
  
  public function setKeyAttribute($value)
  {
    $key = Str::random(48);
    
    $this->attributes['key'] = $key;
  }
}
