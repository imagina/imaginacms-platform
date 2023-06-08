<?php

namespace Modules\Icommerceagree\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Icommerceagree\Entities\IcommerceAgree;
use Modules\Icommerceagree\Http\Requests\CreateIcommerceAgreeRequest;
use Modules\Icommerceagree\Http\Requests\UpdateIcommerceAgreeRequest;
use Modules\Icommerceagree\Repositories\IcommerceAgreeRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class IcommerceAgreeController extends AdminBaseController
{
    /**
     * @var IcommerceAgreeRepository
     */
    private $icommerceagree;

    public function __construct(IcommerceAgreeRepository $icommerceagree)
    {
        parent::__construct();

        $this->icommerceagree = $icommerceagree;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$icommerceagrees = $this->icommerceagree->all();

        return view('icommerceagree::admin.icommerceagrees.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('icommerceagree::admin.icommerceagrees.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateIcommerceAgreeRequest $request
     * @return Response
     */
    public function store(CreateIcommerceAgreeRequest $request)
    {
        $this->icommerceagree->create($request->all());

        return redirect()->route('admin.icommerceagree.icommerceagree.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('icommerceagree::icommerceagrees.title.icommerceagrees')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  IcommerceAgree $icommerceagree
     * @return Response
     */
    public function edit(IcommerceAgree $icommerceagree)
    {
        return view('icommerceagree::admin.icommerceagrees.edit', compact('icommerceagree'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  IcommerceAgree $icommerceagree
     * @param  UpdateIcommerceAgreeRequest $request
     * @return Response
     */
    public function update(IcommerceAgree $icommerceagree, UpdateIcommerceAgreeRequest $request)
    {
        $this->icommerceagree->update($icommerceagree, $request->all());

        return redirect()->route('admin.icommerceagree.icommerceagree.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('icommerceagree::icommerceagrees.title.icommerceagrees')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  IcommerceAgree $icommerceagree
     * @return Response
     */
    public function destroy(IcommerceAgree $icommerceagree)
    {
        $this->icommerceagree->destroy($icommerceagree);

        return redirect()->route('admin.icommerceagree.icommerceagree.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('icommerceagree::icommerceagrees.title.icommerceagrees')]));
    }
}
