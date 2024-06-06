<?php

namespace Modules\Iforms\Facades;

use Illuminate\Support\Facades\Facade;
use Modules\Iforms\Presenters\FormPresenter;


class FormFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return FormPresenter::class;
    }

}