<?php

namespace Modules\Slider\Entities;

use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;
use Modules\Isite\Traits\RevisionableTrait;

use Modules\Core\Support\Traits\AuditTrait;

class Slider extends Model
{
  
  use BelongsToTenant, AuditTrait, RevisionableTrait;

  public $transformer = 'Modules\Slider\Transformers\SliderApiTransformer';
  public $entity = 'Modules\Slider\Entities\Slider';
  public $repository = 'Modules\Slider\Repositories\SliderApiRepository';
  
  protected $fillable = [
    'name',
    'system_name',
    'options',
    'active'
  ];
  protected $fakeColumns = ['options'];

  protected $table = 'slider__sliders';

  public function slides()
  {
    return $this->hasMany(Slide::class)->with('translations')->orderBy('position', 'asc');
  }

  protected function setOptionsAttribute($value)
  {
    $this->attributes['options'] = json_encode($value);
  }

  public function getOptionsAttribute($value)
  {
    return json_decode($value);
  }
}
