<?php

namespace Modules\Iad\Http\Controllers\Admin;

use Illuminate\Http\Response;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Iad\Entities\UpLog;
use Modules\Iad\Http\Requests\CreateUpLogRequest;
use Modules\Iad\Http\Requests\UpdateUpLogRequest;
use Modules\Iad\Repositories\UpLogRepository;

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
     */
    public function index(): Response
    {
        //$uplogs = $this->uplog->all();

        return view('iad::admin.uplogs.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return view('iad::admin.uplogs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateUpLogRequest $request): Response
    {
        $this->uplog->create($request->all());

        return redirect()->route('admin.iad.uplog.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('iad::uplogs.title.uplogs')]));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UpLog $uplog): Response
    {
        return view('iad::admin.uplogs.edit', compact('uplog'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpLog $uplog, UpdateUpLogRequest $request): Response
    {
        $this->uplog->update($uplog, $request->all());

        return redirect()->route('admin.iad.uplog.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('iad::uplogs.title.uplogs')]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UpLog $uplog): Response
    {
        $this->uplog->destroy($uplog);

        return redirect()->route('admin.iad.uplog.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('iad::uplogs.title.uplogs')]));
    }
}
