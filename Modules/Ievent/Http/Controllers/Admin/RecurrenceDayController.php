<?php

namespace Modules\Ievent\Http\Controllers\Admin;

use Illuminate\Http\Response;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Ievent\Entities\RecurrenceDay;
use Modules\Ievent\Http\Requests\CreateRecurrenceDayRequest;
use Modules\Ievent\Http\Requests\UpdateRecurrenceDayRequest;
use Modules\Ievent\Repositories\RecurrenceDayRepository;

class RecurrenceDayController extends AdminBaseController
{
    /**
     * @var RecurrenceDayRepository
     */
    private $recurrenceday;

    public function __construct(RecurrenceDayRepository $recurrenceday)
    {
        parent::__construct();

        $this->recurrenceday = $recurrenceday;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$recurrencedays = $this->recurrenceday->all();

        return view('ievent::admin.recurrencedays.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('ievent::admin.recurrencedays.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(CreateRecurrenceDayRequest $request)
    {
        $this->recurrenceday->create($request->all());

        return redirect()->route('admin.ievent.recurrenceday.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('ievent::recurrencedays.title.recurrencedays')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Response
     */
    public function edit(RecurrenceDay $recurrenceday)
    {
        return view('ievent::admin.recurrencedays.edit', compact('recurrenceday'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return Response
     */
    public function update(RecurrenceDay $recurrenceday, UpdateRecurrenceDayRequest $request)
    {
        $this->recurrenceday->update($recurrenceday, $request->all());

        return redirect()->route('admin.ievent.recurrenceday.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('ievent::recurrencedays.title.recurrencedays')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return Response
     */
    public function destroy(RecurrenceDay $recurrenceday)
    {
        $this->recurrenceday->destroy($recurrenceday);

        return redirect()->route('admin.ievent.recurrenceday.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('ievent::recurrencedays.title.recurrencedays')]));
    }
}
