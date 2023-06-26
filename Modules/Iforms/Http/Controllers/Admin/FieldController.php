<?php

namespace Modules\Iforms\Http\Controllers\Admin;

use Illuminate\Http\Response;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Iforms\Entities\Field;
use Modules\Iforms\Http\Requests\CreateFieldRequest;
use Modules\Iforms\Http\Requests\UpdateFieldRequest;
use Modules\Iforms\Repositories\FieldRepository;

class FieldController extends AdminBaseController
{
    /**
     * @var FieldRepository
     */
    private $field;

    public function __construct(FieldRepository $field)
    {
        parent::__construct();

        $this->field = $field;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        //$fields = $this->field->all();

        return view('iforms::admin.fields.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return view('iforms::admin.fields.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateFieldRequest $request): Response
    {
        $this->field->create($request->all());

        return redirect()->route('admin.iforms.field.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('iforms::fields.title.fields')]));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Field $field): Response
    {
        return view('iforms::admin.fields.edit', compact('field'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Field $field, UpdateFieldRequest $request): Response
    {
        $this->field->update($field, $request->all());

        return redirect()->route('admin.iforms.field.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('iforms::fields.title.fields')]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Field $field): Response
    {
        $this->field->destroy($field);

        return redirect()->route('admin.iforms.field.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('iforms::fields.title.fields')]));
    }
}
