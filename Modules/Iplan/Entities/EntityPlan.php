<?php

namespace Modules\Iplan\Entities;

use Illuminate\Database\Eloquent\Model;

class EntityPlan extends Model
{

    protected $table = 'iplan__entity_plan';
    protected $fillable = [
      "module",
      "entity",
      "status",
    ];

    public function getEntityNameAttribute(){
        $modulesEnabled = app('modules')->allEnabled();
        foreach($modulesEnabled as $name=>$module){
            $cfg = config('asgard.'.strtolower($name).'.config.limitEntities');
            if(!empty($cfg)){
                foreach($cfg as $cf){
                    if($cf['entity'] == $this->entity){
                        return $cf['name'];
                    }
                }
            }
        }
        return '';
    }

}
