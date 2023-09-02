<?php

namespace Modules\Iad\Http\Controllers\Admin;

use Illuminate\Http\Response;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Iad\Entities\Field;
use Modules\Iad\Http\Requests\CreateFieldRequest;
use Modules\Iad\Http\Requests\UpdateFieldRequest;
use Modules\Iad\Repositories\FieldRepository;

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
    public function index()
    {
        //$fields = $this->field->all();

        return view('iad::admin.fields.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('iad::admin.fields.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateFieldRequest $request)
    {
        $this->field->create($request->all());

        return redirect()->route('admin.iad.field.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('iad::fields.title.fields')]));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Field $field)
    {
        return view('iad::admin.fields.edit', compact('field'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Field $field, UpdateFieldRequest $request)
    {
        $this->field->update($field, $request->all());

        return redirect()->route('admin.iad.field.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('iad::fields.title.fields')]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Field $field)
    {
        $this->field->destroy($field);

        return redirect()->route('admin.iad.field.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('iad::fields.title.fields')]));
    }
}
