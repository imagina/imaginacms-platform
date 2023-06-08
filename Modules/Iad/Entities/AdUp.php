<?php

namespace Modules\Iad\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Icrud\Entities\CrudModel;

class AdUp extends CrudModel
{
  public $transformer = 'Modules\Iad\Transformers\AdUpTransformer';
  public $entity = 'Modules\Iad\Entities\AdUp';
  public $repository = 'Modules\Iad\Repositories\AdUpRepository';
  public $requestValidation = [
    'create' => 'Modules\Iad\Http\Requests\CreateAdUpRequest',
    'update' => 'Modules\Iad\Http\Requests\UpdateAdUpRequest',
  ];
    protected $table = 'iad__ad_up';
    protected $fillable = [
      'ad_id',
      'up_id',
      'days_limit',
      'ups_daily',
      'status',
      'order_id',
      'days_counter',
      'ups_counter',
      'from_date',
      'to_date',
      'from_hour',
      'to_hour',
    ];

  public function up()
  {

    return $this->belongsTo(Up::class);
  }

  public function ad()
  {

    return $this->belongsTo(Ad::class);
  }

  public function getRangeMinutesAttribute(){

    $everyUp = config("asgard.iad.config.everyUp");

    return (int)((strtotime($this->to_hour) - strtotime($this->from_hour))/60/$everyUp/$this->ups_daily);
  }

  public function getNextUploadAttribute(){

    if(($this->ups_counter+1)%$this->ups_daily != 0){

      return date("Y-m-d H:i:s",strtotime(date("Y-m-d")." ".$this->from_hour." +".(($this->ups_counter - ($this->days_counter * $this->ups_daily)) * $this->range_minutes)." minutes"));
    }

    return false;
  }
}
