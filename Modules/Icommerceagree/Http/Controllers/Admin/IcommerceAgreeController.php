<?php

namespace Modules\Icommerceagree\Http\Controllers\Admin;

use Illuminate\Http\Response;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Icommerceagree\Entities\IcommerceAgree;
use Modules\Icommerceagree\Http\Requests\CreateIcommerceAgreeRequest;
use Modules\Icommerceagree\Http\Requests\UpdateIcommerceAgreeRequest;
use Modules\Icommerceagree\Repositories\IcommerceAgreeRepository;

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
    public function index(): Response
    {
        //$icommerceagrees = $this->icommerceagree->all();

        return view('icommerceagree::admin.icommerceagrees.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(): Response
    {
        return view('icommerceagree::admin.icommerceagrees.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(CreateIcommerceAgreeRequest $request): Response
    {
        $this->icommerceagree->create($request->all());

        return redirect()->route('admin.icommerceagree.icommerceagree.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('icommerceagree::icommerceagrees.title.icommerceagrees')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Response
     */
    public function edit(IcommerceAgree $icommerceagree): Response
    {
        return view('icommerceagree::admin.icommerceagrees.edit', compact('icommerceagree'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return Response
     */
    public function update(IcommerceAgree $icommerceagree, UpdateIcommerceAgreeRequest $request): Response
    {
        $this->icommerceagree->update($icommerceagree, $request->all());

        return redirect()->route('admin.icommerceagree.icommerceagree.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('icommerceagree::icommerceagrees.title.icommerceagrees')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return Response
     */
    public function destroy(IcommerceAgree $icommerceagree): Response
    {
        $this->icommerceagree->destroy($icommerceagree);

        return redirect()->route('admin.icommerceagree.icommerceagree.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('icommerceagree::icommerceagrees.title.icommerceagrees')]));
    }
}
