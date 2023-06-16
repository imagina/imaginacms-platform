<?php

namespace Modules\Iforms\Support\Traits;

use Modules\Iforms\Entities\Form;

trait Formeable
{
    /**
     * Boot trait method
     */
    public static function bootFormeable()
    {
        //Listen event after create model
        static::createdWithBindings(function ($model) {
            //Sync schedules
            $model->syncForms($model->getEventBindings('createdWithBindings'));
        });
        //Listen event after update model
        static::updatedWithBindings(function ($model) {
            //Sync Schedules
            $model->syncForms($model->getEventBindings('updatedWithBindings'));
        });
        //Listen event after delete model
        static::deleted(function ($model) {
            // ...Do something
        });
    }

    //Sync Forms
    public function syncForms($params)
    {
        //Instance form ID
        $formsId = isset($params['data']['form_id']) && $params['data']['form_id'] ?
          [$params['data']['form_id']] : [];

        //Sync Forms
        $this->forms()->sync($formsId);
    }

    /**
     * Make the Productable morph relation
     *
     * @return object
     */
    public function forms()
    {
        return $this->morphToMany(Form::class, 'formeable', 'iforms__formeable')
          ->withPivot('formeable_type')
          ->withTimestamps();
    }

    public function getFormAttribute()
    {
        return $this->forms->first();
    }
}
