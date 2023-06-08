<?php

namespace Modules\Icheckin\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Icheckin\Entities\Request as RequestEntity;
use Modules\Icheckin\Http\Requests\CreateRequestRequest;
use Modules\Icheckin\Http\Requests\UpdateRequestRequest;
use Modules\Icheckin\Repositories\RequestRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class RequestController extends AdminBaseController
{
    /**
     * @var RequestRepository
     */
    private $request;

    public function __construct(RequestRepository $request)
    {
        parent::__construct();

        $this->request = $request;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$requests = $this->request->all();

        return view('icheckin::admin.requests.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('icheckin::admin.requests.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateRequestRequest $request
     * @return Response
     */
    public function store(CreateRequestRequest $request)
    {
        $this->request->create($request->all());

        return redirect()->route('admin.icheckin.request.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('icheckin::requests.title.requests')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Request $request
     * @return Response
     */
    public function edit(RequestEntity $request)
    {
        return view('icheckin::admin.requests.edit', compact('request'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     * @param  UpdateRequestRequest $request
     * @return Response
     */
    public function update(RequestEntity $requestEntity, UpdateRequestRequest $request)
    {
        $this->request->update($requestEntity, $request->all());

        return redirect()->route('admin.icheckin.request.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('icheckin::requests.title.requests')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function destroy(RequestEntity $request)
    {
        $this->request->destroy($request);

        return redirect()->route('admin.icheckin.request.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('icheckin::requests.title.requests')]));
    }
}
