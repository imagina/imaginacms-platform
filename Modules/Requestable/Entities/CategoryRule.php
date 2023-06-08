<?php

namespace Modules\Requestable\Entities;

use Astrotomic\Translatable\Translatable;
use Modules\Core\Icrud\Entities\CrudModel;
use Illuminate\Support\Str;

use Kalnoy\Nestedset\NodeTrait;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

//Static Classes
use Modules\Requestable\Entities\StatusGeneral;

class CategoryRule extends CrudModel
{
  use Translatable, NodeTrait;

  protected $table = 'requestable__category_rules';
  public $transformer = 'Modules\Requestable\Transformers\CategoryRuleTransformer';
  public $repository = 'Modules\Requestable\Repositories\CategoryRuleRepository';
  public $requestValidation = [
      'create' => 'Modules\Requestable\Http\Requests\CreateCategoryRuleRequest',
      'update' => 'Modules\Requestable\Http\Requests\UpdateCategoryRuleRequest',
    ];
  //Instance external/internal events to dispatch with extraData
  public $dispatchesEventsWithBindings = [
    //eg. ['path' => 'path/module/event', 'extraData' => [/*...optional*/]]
    'created' => [],
    'creating' => [],
    'updated' => [],
    'updating' => [],
    'deleting' => [],
    'deleted' => []
  ];
  public $translatedAttributes = [
    'title'
  ];

  protected $fillable = [
    'system_name',
    'internal',
    'parent_id',
    'status',
    'form_fields',
    'options'
  ];

  protected $casts = [
    'options' => 'array',
    'form_fields' => 'array'
  ];

  //============== RELATIONS ==============//

  public function parent()
  {
    return $this->belongsTo(CategoryRule::class, 'parent_id');
  }

  public function children()
  {
    return $this->hasMany(CategoryRule::class, 'parent_id');
  }

  public function automationRules()
  {
    return $this->hasMany(AutomationRule::class);
  }

  public function getStatusNameAttribute()
  {
    $status = new StatusGeneral();
    return $status->get($this->status);
  }

  //==================== ACCESORS ==============//

  public function getLftName()
  {
    return 'lft';
  }

  public function getRgtName()
  {
    return 'rgt';
  }

  public function getDepthName()
  {
    return 'depth';
  }

  public function getParentIdName()
  {
    return 'parent_id';
  }

  public function getOptionsAttribute($value)
  {
    return json_decode($value);
  }

  public function getFormFieldsAttribute($value)
  {
    return json_decode($value);
  }

  //==================== MUTATORS ==============//

  public function setOptionsAttribute($value)
  {
    $this->attributes['options'] = json_encode($value);
  }

  public function setSystemNameAttribute($value)
  {

    if(empty($value) || is_null($value)){
      $this->attributes['system_name'] = Str::slug($this->title, '-');
    }else{
      $this->attributes['system_name'] = $value;
    }

  }

  public function setFormFieldsAttribute($value)
  {
    $this->attributes['form_fields'] = json_encode($value);
  }

}
