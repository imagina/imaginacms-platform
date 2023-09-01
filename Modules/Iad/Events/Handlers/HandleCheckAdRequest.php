<?php

namespace Modules\Iad\Events\Handlers;

use Modules\Iad\Entities\Ad;
use Modules\User\Entities\Sentinel\User;

class HandleCheckAdRequest
{
    public function handle($event)
    {
        //Instance event parameters
        $request = $event->request;
        $action = $event->action;

        if ($request && ($request->requestable_type === "Modules\Iad\Entities\Ad")) {
            //Request created
            $this->notifyAdRequest($action, $request);

            //Request updated
            if ($action == 'updated') {
                //Instance request status value
                $requestStatus = $request->status->value;
                //Request completed
                if ($requestStatus == 3) {
                    //Set ad as checked
                    Ad::where('id', $request->requestable_id)->update(['checked' => 1]);
                }
            }
        }
    }

    /**
     * Dispath notification about action type
     */
    private function notifyAdRequest($action, $request)
    {
        $inotification = app('Modules\Notification\Services\Inotification');

        //Request created
        if ($action == 'created') {
            //get Users to notify
            $settingValue = json_decode(setting('iad::usersToNotify') ?? []);
            $settingUserManageRequestables = User::whereIn('id', $settingValue)->get();
            //Send pusher notification
            $inotification->to([
                'broadcast' => $settingUserManageRequestables->pluck('id')->toArray(),
                'email' => $settingUserManageRequestables->pluck('email')->toArray(),
            ])->push([
                'title' => trans('iad::iad.requestable.notifyNewRequest.title'),
                'message' => trans('iad::iad.requestable.notifyNewRequest.message'),
                'link' => url('iadmin/#/requestable/index/'),
                'buttonText' => trans('iad::iad.requestable.notifyNewRequest.viewRequests'),
                'withButton' => true,
                'setting' => ['saveInDatabase' => 1],
            ]);
        } else {
            //get Users to notify
            $status = \Modules\Requestable\Entities\Status::find($request->status_id);
            $settingUserManageRequestables = User::where('id', $request->created_by)->get();
            //Send pusher notification
            $inotification->to([
                'broadcast' => $settingUserManageRequestables->pluck('id')->toArray(),
                'email' => $settingUserManageRequestables->pluck('email')->toArray(),
            ])->push([
                'title' => trans('iad::iad.requestable.notifyUpdateRequest.title'),
                'message' => trans('iad::iad.requestable.notifyUpdateRequest.message', ['status' => $status->title]),
                'link' => url('iadmin/#/requestable/index/'),
                'buttonText' => trans('iad::iad.requestable.notifyNewRequest.viewRequests'),
                'withButton' => true,
                'setting' => ['saveInDatabase' => 1],
            ]);
        }
    }
}
