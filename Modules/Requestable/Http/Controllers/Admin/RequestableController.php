<?php

namespace Modules\Requestable\Http\Controllers\Admin;

use Illuminate\Http\Response;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Requestable\Entities\Requestable;
use Modules\Requestable\Http\Requests\CreateRequestableRequest;
use Modules\Requestable\Http\Requests\UpdateRequestableRequest;
use Modules\Requestable\Repositories\RequestableRepository;

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
     */
    public function index(): Response
    {
        //$requestables = $this->requestable->all();

        return view('requestable::admin.requestables.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return view('requestable::admin.requestables.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateRequestableRequest $request): Response
    {
        $this->requestable->create($request->all());

        return redirect()->route('admin.requestable.requestable.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('requestable::requestables.title.requestables')]));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Requestable $requestable): Response
    {
        return view('requestable::admin.requestables.edit', compact('requestable'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Requestable $requestable, UpdateRequestableRequest $request): Response
    {
        $this->requestable->update($requestable, $request->all());

        return redirect()->route('admin.requestable.requestable.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('requestable::requestables.title.requestables')]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Requestable $requestable): Response
    {
        $this->requestable->destroy($requestable);

        return redirect()->route('admin.requestable.requestable.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('requestable::requestables.title.requestables')]));
    }
}
