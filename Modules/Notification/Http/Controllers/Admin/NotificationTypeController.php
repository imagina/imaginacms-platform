<?php

namespace Modules\Notification\Http\Controllers\Admin;

use Illuminate\Http\Response;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Notification\Entities\NotificationType;
use Modules\Notification\Http\Requests\CreateNotificationTypeRequest;
use Modules\Notification\Http\Requests\UpdateNotificationTypeRequest;
use Modules\Notification\Repositories\NotificationTypeRepository;

class NotificationTypeController extends AdminBaseController
{
    /**
     * @var NotificationTypeRepository
     */
    private $notificationtype;

    public function __construct(NotificationTypeRepository $notificationtype)
    {
        parent::__construct();

        $this->notificationtype = $notificationtype;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        //$notificationtypes = $this->notificationtype->all();

        return view('notification::admin.notificationtypes.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return view('notification::admin.notificationtypes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateNotificationTypeRequest $request): Response
    {
        $this->notificationtype->create($request->all());

        return redirect()->route('admin.notification.notificationtype.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('notification::notificationtypes.title.notificationtypes')]));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(NotificationType $notificationtype): Response
    {
        return view('notification::admin.notificationtypes.edit', compact('notificationtype'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(NotificationType $notificationtype, UpdateNotificationTypeRequest $request): Response
    {
        $this->notificationtype->update($notificationtype, $request->all());

        return redirect()->route('admin.notification.notificationtype.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('notification::notificationtypes.title.notificationtypes')]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NotificationType $notificationtype): Response
    {
        $this->notificationtype->destroy($notificationtype);

        return redirect()->route('admin.notification.notificationtype.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('notification::notificationtypes.title.notificationtypes')]));
    }
}
