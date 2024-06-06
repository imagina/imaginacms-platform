<?php

use Modules\Iforms\Entities\Form;

if (! function_exists('iform')) {

    function iform($id,$template,$options=array()) {

        $default_options=['rand'=>rand(0,100)];
        $options = array_merge($default_options, $options);

        $iform = Form::find($id);

        $view = View::make($template)
            ->with([
                'form' => $iform,
                'options' => $options,
            ]);
        return $view->render();
    }
}