<?php

namespace Modules\Iad\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Iad\Entities\UpLog;
use Modules\Iad\Http\Requests\CreateUpLogRequest;
use Modules\Iad\Http\Requests\UpdateUpLogRequest;
use Modules\Iad\Repositories\UpLogRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class UpLogController extends AdminBaseController
{
    /**
     * @var UpLogRepository
     */
    private $uplog;

    public function __construct(UpLogRepository $uplog)
    {
        parent::__construct();

        $this->uplog = $uplog;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$uplogs = $this->uplog->all();

        return view('iad::admin.uplogs.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('iad::admin.uplogs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateUpLogRequest $request
     * @return Response
     */
    public function store(CreateUpLogRequest $request)
    {
        $this->uplog->create($request->all());

        return redirect()->route('admin.iad.uplog.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('iad::uplogs.title.uplogs')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  UpLog $uplog
     * @return Response
     */
    public function edit(UpLog $uplog)
    {
        return view('iad::admin.uplogs.edit', compact('uplog'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpLog $uplog
     * @param  UpdateUpLogRequest $request
     * @return Response
     */
    public function update(UpLog $uplog, UpdateUpLogRequest $request)
    {
        $this->uplog->update($uplog, $request->all());

        return redirect()->route('admin.iad.uplog.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('iad::uplogs.title.uplogs')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  UpLog $uplog
     * @return Response
     */
    public function destroy(UpLog $uplog)
    {
        $this->uplog->destroy($uplog);

        return redirect()->route('admin.iad.uplog.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('iad::uplogs.title.uplogs')]));
    }
}
