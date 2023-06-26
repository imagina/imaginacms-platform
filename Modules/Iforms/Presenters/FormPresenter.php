<?php

namespace Modules\Iforms\Presenters;

use Illuminate\Support\Facades\View;
use Modules\Iforms\Entities\Form;

class FormPresenter extends AbstractFormPresenter implements FormPresenterInterface
{
    /**
     * renders Form.
     *
     * @param  string|Form  $form
     * pass Form instance to render specific Form
     * pass string to automatically retrieve Form from repository
     * @param  string  $template blade template to render Form
     * @return string rendered Form HTML
     */
    public function render($form, string $template = 'iforms::frontend.form.bt-horizontal.form', array $options = []): string
    {
        $default_options = ['rand' => rand(0, 100)];
        $options = array_merge($default_options, $options);
        if (! $form instanceof Form) {
            $form = $this->getFormFromRepository($form);
            /*if ($form && $form->active == false) {    // inactive Form must not render
                 return '';
             }*/
        }
        if (! $form) {
            return '';
        }

        $view = View::make($template)
            ->with([
                'form' => $form,
                'options' => $options,
            ]);

        return $view->render();
    }

    private function getFormFromRepository($systemName): Form
    {
        return $this->formRepository->findBySystemName($systemName);
    }
}
