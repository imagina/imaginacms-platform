<?php


namespace Modules\Iforms\View\Components;

use Illuminate\View\Component;

class Newsletter extends Component
{

    public $id;
    public $layout;
    public $form;
    public $title;
    public $description;
    public $postDescription;
    public $submitLabel;
    public $view;
    public $central;
    public $titleClasses;
    public $descriptionClasses;
    public $postDescriptionClasses;
    public $buttonClasses;
    public $inputClasses;

    public function __construct($layout = 'newsletter-layout-1',
                                $title = '',
                                $description = '',
                                $submitLabel = '',
                                $postDescription = "",
                                $central = false,
                                $titleClasses = 'mb-0',
                                $descriptionClasses = 'mb-3',
                                $postDescriptionClasses = "mb-3",
                                $buttonClasses = "btn btn-primary px-3",
                                $inputClasses = "bg-transparent"
    )
    {
        $this->layout = $layout ?? 'newsletter-layout-1';
        $this->view = "iforms::frontend.components.newsletter.layouts.{$this->layout}.index";
        $this->title = $title ?? '';
        $this->description = $description;
        $this->postDescription = $postDescription;
        $this->titleClasses = $titleClasses;
        $this->descriptionClasses = $descriptionClasses;
        $this->buttonClasses = $buttonClasses;
        $this->inputClasses = $inputClasses;
        $this->postDescriptionClasses = $postDescriptionClasses;
        $this->submitLabel = $submitLabel ?? trans('iforms::forms.button.subscribe');
        $this->central = $central;
        $this->getOrAddForm();
    }

    public function getOrAddForm(){
        $params = [
            'include' => ['fields'],
            'filter' => [
                'field' => 'system_name'
            ],
            'fields' => [],
        ];

        if($this->central)
            $params["filter"]["notOrganization"] = true;
    
        $this->form = app('Modules\\Iforms\\Repositories\\FormRepository')->getItem('newsletter',json_decode(json_encode($params)));

        if(empty($this->form)){
            $formData = [
                'system_name' => 'newsletter',
                'title' => $this->title,
                'active' => 1,
            ];
            $this->form = app('Modules\\Iforms\\Repositories\\FormRepository')->create($formData);
            $newFieldData = [
                'required' => 1,
                'name' => trans('iforms::fields.form.email.name'),
                'label' => trans('iforms::fields.form.email.label'),
                'placeholder' => trans('iforms::fields.form.email.placeholder'),
                'description' => trans('iforms::fields.form.email.description'),
                'type' => 'email',
                'form_id' => $this->form->id,
            ];
            app('Modules\\Iforms\\Repositories\\FieldRepository')->create($newFieldData);

        }
        
    }

    public function render()
    {
        return view($this->view);
    }
}
