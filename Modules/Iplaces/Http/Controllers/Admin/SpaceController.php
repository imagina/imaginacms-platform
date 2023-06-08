<?php

namespace Modules\Iplaces\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Iplaces\Entities\Space;
use Modules\Iplaces\Http\Requests\CreateSpaceRequest;
use Modules\Iplaces\Http\Requests\UpdateSpaceRequest;
use Modules\Iplaces\Repositories\SpaceRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Iplaces\Entities\Status;

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
        $this->status=$status;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $spaces = $this->space->all();
        return view('iplaces::admin.spaces.index', compact('spaces'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('iplaces::admin.spaces.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateSpaceRequest $request
     * @return Response
     */
    public function store(CreateSpaceRequest $request)
    {

        try {

            $this->space->create($request->all());
            return redirect()->route('admin.iplaces.space.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('iplaces::spaces.title.spaces')]));
            
        }catch(\Exception $e){
            \Log::error($e);
            
            return redirect()->back()
                ->withError(trans('core::core.messages.resource error', ['name' => trans('iplaces::spaces.title.spaces')]))->withInput($request->all());
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Space $space
     * @return Response
     */
    public function edit(Space $space)
    {
        return view('iplaces::admin.spaces.edit', compact('space'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Space $space
     * @param  UpdateSpaceRequest $request
     * @return Response
     */
    public function update(Space $space, UpdateSpaceRequest $request)
    {
        
        try{
            $this->space->update($space, $request->all());
            return redirect()->route('admin.iplaces.space.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('iplaces::spaces.title.spaces')]));

        }catch(\Exception $e){

            \Log::error($e);
            return redirect()->back()
                ->withError(trans('core::core.messages.resource error', ['name' => trans('iplaces::services.title.services')]))->withInput($request->all());
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Space $space
     * @return Response
     */
    public function destroy(Space $space)
    {
        $this->space->destroy($space);

        return redirect()->route('admin.iplaces.space.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('iplaces::spaces.title.spaces')]));
    }
}
