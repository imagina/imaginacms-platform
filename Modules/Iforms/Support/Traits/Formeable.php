<?php


namespace Modules\Iforms\Support\Traits;


use Modules\Iforms\Entities\Form;

Trait Formeable
{

    /**
     * Make the Productable morph relation
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
