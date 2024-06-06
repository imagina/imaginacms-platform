<?php

namespace Modules\Iforms\Presenters;

use Laracasts\Presenter\Presenter;

class FieldPresenter extends Presenter
{
    /**
     * @var \Modules\Iforms\Entities\Type
     */
    protected $types;
    /**
     * @var \Modules\Iforms\Repositories\FieldRepository
     */
    private $field;

    public function __construct($entity)
    {
        parent::__construct($entity);
        $this->field = app('Modules\Iforms\Repositories\FieldRepository');
        $this->types = app('Modules\Iforms\Entities\Type');
    }

    public function type()
    {
        return $this->types->get($this->entity->type);
    }



}
