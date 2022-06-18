<?php namespace Modules\Slider\Entities;

use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class Slider extends Model
{
  
  use BelongsToTenant;
  
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
