<?php

namespace Modules\Requestable\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Requestable\Entities\Requestable;
use Modules\Requestable\Http\Requests\CreateRequestableRequest;
use Modules\Requestable\Http\Requests\UpdateRequestableRequest;
use Modules\Requestable\Repositories\RequestableRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class RequestableController extends AdminBaseController
{
    /**
     * @var RequestableRepository
     */
    private $requestable;

    public function __construct(RequestableRepository $requestable)
    {
        parent::__construct();

        $this->requestable = $requestable;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$requestables = $this->requestable->all();

        return view('requestable::admin.requestables.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('requestable::admin.requestables.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateRequestableRequest $request
     * @return Response
     */
    public function store(CreateRequestableRequest $request)
    {
        $this->requestable->create($request->all());

        return redirect()->route('admin.requestable.requestable.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('requestable::requestables.title.requestables')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Requestable $requestable
     * @return Response
     */
    public function edit(Requestable $requestable)
    {
        return view('requestable::admin.requestables.edit', compact('requestable'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Requestable $requestable
     * @param  UpdateRequestableRequest $request
     * @return Response
     */
    public function update(Requestable $requestable, UpdateRequestableRequest $request)
    {
        $this->requestable->update($requestable, $request->all());

        return redirect()->route('admin.requestable.requestable.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('requestable::requestables.title.requestables')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Requestable $requestable
     * @return Response
     */
    public function destroy(Requestable $requestable)
    {
        $this->requestable->destroy($requestable);

        return redirect()->route('admin.requestable.requestable.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('requestable::requestables.title.requestables')]));
    }
}
