<?php

namespace Modules\Isite\Traits;

use Modules\Isite\Entities\Layout;

trait Typeable
{
    /**
     * Boot trait method
     */
    public static function bootTypeable()
    {
        //Listen event after create model
        static::createdWithBindings(function ($model) {
            //Sync schedules
            $model->syncTypeable($model->getEventBindings('createdWithBindings'));
        });
        //Listen event after update model
        static::updatedWithBindings(function ($model) {
            //Sync Schedules
            $model->syncTypeable($model->getEventBindings('updatedWithBindings'));
        });
        //Listen event after delete model
        static::deleted(function ($model) {
            $model->typeable()->forceDelete();
        });
    }

    /**
     * Create schedule to entity
     */
    public function syncTypeable($params)
    {
        if (isset($params['data']['layout_id'])) {
            $layoutId = $params['data']['layout_id'];

            $layout = Layout::find($layoutId);

            if (isset($layout->id)) {
                \Modules\Isite\Entities\Typeable::updateOrCreate([
                    'typeable_type' => get_class($this),
                    'typeable_id' => $this->id,
                ], [
                    'layout_path' => $layout->path,
                    'layout_id' => $layoutId,
                ]);
            }
        }
    }

    /**
     * Return the typeable resource
     */
    public function typeable()
    {
        return $this->morphOne("Modules\Isite\Entities\Typeable", 'typeable');
    }

    /**
     * magic method to return the layout from the typeable
     */
    public function getLayoutIdAttribute()
    {
        return $this->typeable->layout_id ?? null;
    }
}
