<?php

namespace Modules\Icheckin\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Icheckin\Entities\Shift;
use Modules\Icheckin\Http\Requests\CreateShiftRequest;
use Modules\Icheckin\Http\Requests\UpdateShiftRequest;
use Modules\Icheckin\Repositories\ShiftRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class ShiftController extends AdminBaseController
{
    /**
     * @var ShiftRepository
     */
    private $shift;

    public function __construct(ShiftRepository $shift)
    {
        parent::__construct();

        $this->shift = $shift;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$shifts = $this->shift->all();

        return view('icheckin::admin.shifts.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('icheckin::admin.shifts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateShiftRequest $request
     * @return Response
     */
    public function store(CreateShiftRequest $request)
    {
        $this->shift->create($request->all());

        return redirect()->route('admin.icheckin.shift.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('icheckin::shifts.title.shifts')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Shift $shift
     * @return Response
     */
    public function edit(Shift $shift)
    {
        return view('icheckin::admin.shifts.edit', compact('shift'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Shift $shift
     * @param  UpdateShiftRequest $request
     * @return Response
     */
    public function update(Shift $shift, UpdateShiftRequest $request)
    {
        $this->shift->update($shift, $request->all());

        return redirect()->route('admin.icheckin.shift.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('icheckin::shifts.title.shifts')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Shift $shift
     * @return Response
     */
    public function destroy(Shift $shift)
    {
        $this->shift->destroy($shift);

        return redirect()->route('admin.icheckin.shift.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('icheckin::shifts.title.shifts')]));
    }
}
