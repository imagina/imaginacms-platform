<?php

namespace Modules\Notification\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Notification\Entities\NotificationType;
use Modules\Notification\Http\Requests\CreateNotificationTypeRequest;
use Modules\Notification\Http\Requests\UpdateNotificationTypeRequest;
use Modules\Notification\Repositories\NotificationTypeRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

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
     *
     * @return Response
     */
    public function index()
    {
        //$notificationtypes = $this->notificationtype->all();

        return view('notification::admin.notificationtypes.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('notification::admin.notificationtypes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateNotificationTypeRequest $request
     * @return Response
     */
    public function store(CreateNotificationTypeRequest $request)
    {
        $this->notificationtype->create($request->all());

        return redirect()->route('admin.notification.notificationtype.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('notification::notificationtypes.title.notificationtypes')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  NotificationType $notificationtype
     * @return Response
     */
    public function edit(NotificationType $notificationtype)
    {
        return view('notification::admin.notificationtypes.edit', compact('notificationtype'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  NotificationType $notificationtype
     * @param  UpdateNotificationTypeRequest $request
     * @return Response
     */
    public function update(NotificationType $notificationtype, UpdateNotificationTypeRequest $request)
    {
        $this->notificationtype->update($notificationtype, $request->all());

        return redirect()->route('admin.notification.notificationtype.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('notification::notificationtypes.title.notificationtypes')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  NotificationType $notificationtype
     * @return Response
     */
    public function destroy(NotificationType $notificationtype)
    {
        $this->notificationtype->destroy($notificationtype);

        return redirect()->route('admin.notification.notificationtype.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('notification::notificationtypes.title.notificationtypes')]));
    }
}
