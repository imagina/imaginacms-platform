<?php

namespace Modules\Iprofile\Http\Controllers\Admin;

use Illuminate\Http\Response;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Iprofile\Entities\Field;
use Modules\Iprofile\Http\Requests\CreateCustomFieldRequest;
use Modules\Iprofile\Http\Requests\UpdateCustomFieldRequest;
use Modules\Iprofile\Repositories\FieldRepository;

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
     */
    public function index(): Response
    {
        //$customfields = $this->customfield->all();

        return view('Iprofile::admin.customfields.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return view('Iprofile::admin.customfields.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateCustomFieldRequest $request): Response
    {
        $this->customfield->create($request->all());

        return redirect()->route('admin.Iprofile.customfield.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('Iprofile::customfields.title.customfields')]));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Field $customfield): Response
    {
        return view('Iprofile::admin.customfields.edit', compact('customfield'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Field $customfield, UpdateCustomFieldRequest $request): Response
    {
        $this->customfield->update($customfield, $request->all());

        return redirect()->route('admin.Iprofile.customfield.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('Iprofile::customfields.title.customfields')]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Field $customfield): Response
    {
        $this->customfield->destroy($customfield);

        return redirect()->route('admin.Iprofile.customfield.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('Iprofile::customfields.title.customfields')]));
    }
}
