<?php

namespace Modules\Iprofile\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Iprofile\Entities\Field;
use Modules\Iprofile\Http\Requests\CreateCustomFieldRequest;
use Modules\Iprofile\Http\Requests\UpdateCustomFieldRequest;
use Modules\Iprofile\Repositories\FieldRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class CustomfieldController extends AdminBaseController
{
    /**
     * @var FieldRepository
     */
    private $customfield;

    public function __construct(FieldRepository $customfield)
    {
        parent::__construct();

        $this->customfield = $customfield;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$customfields = $this->customfield->all();

        return view('Iprofile::admin.customfields.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('Iprofile::admin.customfields.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateCustomFieldRequest $request
     * @return Response
     */
    public function store(CreateCustomFieldRequest $request)
    {
        $this->customfield->create($request->all());

        return redirect()->route('admin.Iprofile.customfield.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('Iprofile::customfields.title.customfields')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Field $customfield
     * @return Response
     */
    public function edit(Field $customfield)
    {
        return view('Iprofile::admin.customfields.edit', compact('customfield'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Field $customfield
     * @param  UpdateCustomFieldRequest $request
     * @return Response
     */
    public function update(Field $customfield, UpdateCustomFieldRequest $request)
    {
        $this->customfield->update($customfield, $request->all());

        return redirect()->route('admin.Iprofile.customfield.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('Iprofile::customfields.title.customfields')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Field $customfield
     * @return Response
     */
    public function destroy(Field $customfield)
    {
        $this->customfield->destroy($customfield);

        return redirect()->route('admin.Iprofile.customfield.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('Iprofile::customfields.title.customfields')]));
    }
}
