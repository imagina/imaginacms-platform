<?php

namespace Modules\Iforms\Http\Controllers\Admin;

use Illuminate\Http\Response;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Iforms\Entities\Form;
use Modules\Iforms\Http\Requests\CreateFormRequest;
use Modules\Iforms\Http\Requests\UpdateFormRequest;
use Modules\Iforms\Repositories\FormRepository;

class FormController extends AdminBaseController
{
    /**
     * @var FormRepository
     */
    private $form;

    public function __construct(FormRepository $form)
    {
        parent::__construct();

        $this->form = $form;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        //$forms = $this->form->all();

        return view('iforms::admin.forms.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return view('iforms::admin.forms.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateFormRequest $request): Response
    {
        $this->form->create($request->all());

        return redirect()->route('admin.iforms.form.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('iforms::forms.title.forms')]));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Form $form): Response
    {
        return view('iforms::admin.forms.edit', compact('form'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Form $form, UpdateFormRequest $request): Response
    {
        $this->form->update($form, $request->all());

        return redirect()->route('admin.iforms.form.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('iforms::forms.title.forms')]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Form $form): Response
    {
        $this->form->destroy($form);

        return redirect()->route('admin.iforms.form.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('iforms::forms.title.forms')]));
    }
}
