<?php

namespace Modules\Iforms\Presenters;

interface FormPresenterInterface
{
    /**
     * @return string rendered slider
     */
    public function render($formName);
}
