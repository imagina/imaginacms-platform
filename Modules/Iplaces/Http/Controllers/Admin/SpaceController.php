<?php

namespace Modules\Iplaces\Http\Controllers\Admin;

use Illuminate\Http\Response;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Iplaces\Entities\Space;
use Modules\Iplaces\Entities\Status;
use Modules\Iplaces\Http\Requests\CreateSpaceRequest;
use Modules\Iplaces\Http\Requests\UpdateSpaceRequest;
use Modules\Iplaces\Repositories\SpaceRepository;

class SpaceController extends AdminBaseController
{
    /**
     * @var SpaceRepository
     */
    private $space;

    public $status;

    public function __construct(SpaceRepository $space, Status $status)
    {
        parent::__construct();

        $this->space = $space;
        $this->status = $status;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $spaces = $this->space->all();

        return view('iplaces::admin.spaces.index', compact('spaces'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return view('iplaces::admin.spaces.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateSpaceRequest $request): Response
    {
        try {
            $this->space->create($request->all());

            return redirect()->route('admin.iplaces.space.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('iplaces::spaces.title.spaces')]));
        } catch(\Exception $e) {
            \Log::error($e);

            return redirect()->back()
                ->withError(trans('core::core.messages.resource error', ['name' => trans('iplaces::spaces.title.spaces')]))->withInput($request->all());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Space $space): Response
    {
        return view('iplaces::admin.spaces.edit', compact('space'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Space $space, UpdateSpaceRequest $request): Response
    {
        try {
            $this->space->update($space, $request->all());

            return redirect()->route('admin.iplaces.space.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('iplaces::spaces.title.spaces')]));
        } catch(\Exception $e) {
            \Log::error($e);

            return redirect()->back()
                ->withError(trans('core::core.messages.resource error', ['name' => trans('iplaces::services.title.services')]))->withInput($request->all());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Space $space): Response
    {
        $this->space->destroy($space);

        return redirect()->route('admin.iplaces.space.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('iplaces::spaces.title.spaces')]));
    }
}
