<?php


namespace Modules\Iforms\View\Components;

use Illuminate\Support\Str;
use Illuminate\View\Component;

class Form extends Component
{

  public $id;
  public $layout;
  public $fieldsParams;
  public $form;
  public $formId;
  public $formRepository;
  public $livewireSubmitEvent;
  public $view;
  public $jsSubmitEvent;

  public function __construct($id, $layout = 'form-layout-1', $livewireSubmitEvent = null, $params = [],
                              $fieldsParams = [], $formId = null, $jsSubmitEvent = null)
  {
    $this->id = $id;
    $this->layout = $layout ?? 'form-layout-1';
    $this->fieldsParams = $fieldsParams ?? [];
    $this->view = "iforms::frontend.components.form.layouts.{$this->layout}.index";
    $this->formRepository = app('Modules\\Iforms\\Repositories\\FormRepository');
    $this->getForm();
    $this->livewireSubmitEvent = $livewireSubmitEvent ?? null;
    $this->formId = Str::slug($this->form->system_name, '_') . ($formId ?? '');
    $this->jsSubmitEvent = $jsSubmitEvent ?? null;
  }

  public function getForm()
  {

    $params = $this->makeParamsFunction();

    $this->form = $this->formRepository->getItem($this->id, json_decode(json_encode($params)));
  }

  private function makeParamsFunction()
  {

    return [
      "include" => $this->params["include"] ?? ["*"],
      "fields" => [],
      "take" => $this->params["take"] ?? false,
      "page" => $this->params["page"] ?? false,
      "filter" => $this->params["filter"] ?? [],
      "order" => $this->params["order"] ?? null
    ];
  }

  public function render()
  {
    return view($this->view);
  }
}
