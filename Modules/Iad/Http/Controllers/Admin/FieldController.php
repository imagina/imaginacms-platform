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
     *
     * @return Response
     */
    public function index(): Response
    {
        //$fields = $this->field->all();

        return view('iad::admin.fields.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(): Response
    {
        return view('iad::admin.fields.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(CreateFieldRequest $request): Response
    {
        $this->field->create($request->all());

        return redirect()->route('admin.iad.field.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('iad::fields.title.fields')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Response
     */
    public function edit(Field $field): Response
    {
        return view('iad::admin.fields.edit', compact('field'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return Response
     */
    public function update(Field $field, UpdateFieldRequest $request): Response
    {
        $this->field->update($field, $request->all());

        return redirect()->route('admin.iad.field.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('iad::fields.title.fields')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return Response
     */
    public function destroy(Field $field): Response
    {
        $this->field->destroy($field);

        return redirect()->route('admin.iad.field.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('iad::fields.title.fields')]));
    }
}
