<?php

namespace Modules\Ievent\Http\Controllers\Admin;

use Illuminate\Http\Response;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Ievent\Entities\Event;
use Modules\Ievent\Http\Requests\CreateEventRequest;
use Modules\Ievent\Http\Requests\UpdateEventRequest;
use Modules\Ievent\Repositories\EventRepository;

class EventController extends AdminBaseController
{
    /**
     * @var EventRepository
     */
    private $event;

    public function __construct(EventRepository $event)
    {
        parent::__construct();

        $this->event = $event;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(): Response
    {
        //$events = $this->event->all();

        return view('ievent::admin.events.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(): Response
    {
        return view('ievent::admin.events.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(CreateEventRequest $request): Response
    {
        $this->event->create($request->all());

        return redirect()->route('admin.ievent.event.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('ievent::events.title.events')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Response
     */
    public function edit(Event $event): Response
    {
        return view('ievent::admin.events.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return Response
     */
    public function update(Event $event, UpdateEventRequest $request): Response
    {
        $this->event->update($event, $request->all());

        return redirect()->route('admin.ievent.event.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('ievent::events.title.events')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return Response
     */
    public function destroy(Event $event): Response
    {
        $this->event->destroy($event);

        return redirect()->route('admin.ievent.event.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('ievent::events.title.events')]));
    }
}
