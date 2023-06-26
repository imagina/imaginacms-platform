<?php

namespace Modules\Icheckin\Http\Controllers\Admin;

use Illuminate\Http\Response;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Icheckin\Entities\Shift;
use Modules\Icheckin\Http\Requests\CreateShiftRequest;
use Modules\Icheckin\Http\Requests\UpdateShiftRequest;
use Modules\Icheckin\Repositories\ShiftRepository;

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
     */
    public function index(): Response
    {
        //$shifts = $this->shift->all();

        return view('icheckin::admin.shifts.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return view('icheckin::admin.shifts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateShiftRequest $request): Response
    {
        $this->shift->create($request->all());

        return redirect()->route('admin.icheckin.shift.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('icheckin::shifts.title.shifts')]));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Shift $shift): Response
    {
        return view('icheckin::admin.shifts.edit', compact('shift'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Shift $shift, UpdateShiftRequest $request): Response
    {
        $this->shift->update($shift, $request->all());

        return redirect()->route('admin.icheckin.shift.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('icheckin::shifts.title.shifts')]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Shift $shift): Response
    {
        $this->shift->destroy($shift);

        return redirect()->route('admin.icheckin.shift.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('icheckin::shifts.title.shifts')]));
    }
}
