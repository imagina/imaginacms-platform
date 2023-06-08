<?php

namespace Modules\Ievent\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Modules\Media\Support\Traits\MediaRelation;
use Modules\Media\Entities\File;

class Recurrence extends Model
{
  use MediaRelation, AuditTrait;

    protected $table = 'ievent__recurrences';

    protected $fillable = [
      'related_name',
      'information',
      'user_id',
      'department_id',
      'start_date',
      'end_date',
    ];

  protected $fakeColumns = ['information'];

  protected $casts = [
    'information' => 'array'
  ];


  public function recurrenceDays(){
    return $this->hasMany(RecurrenceDay::class);
  }

  public function getInformationsAttribute($value)
  {
    return json_decode($value);
  }

  public function setInformationsAttribute($value)
  {
    $this->attributes['information'] = json_encode($value);
  }

  public function getMainImageAttribute()
  {
    $thumbnail = $this->files()->where('zone', 'mainimage')->first();
    if (!$thumbnail) return [
      'mimeType' => 'image/jpeg',
      'path' => url('modules/iblog/img/category/default.jpg')
    ];
    return [
      'mimeType' => $thumbnail->mimetype,
      'path' => $thumbnail->path_string
    ];
  }

}
