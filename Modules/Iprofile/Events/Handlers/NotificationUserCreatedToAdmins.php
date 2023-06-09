<?php

namespace Modules\Iprofile\Events\Handlers;

class NotificationUserCreatedToAdmins
{
    public function handle($event = null)
    {
        $user = $event->user;
        $userToNotify = json_decode(setting('isite::usersToNotify'));
        $emailToNotify = json_decode(setting('isite::emailsToNotify'));

        $notification = app("Modules\Notification\Services\Inotification");
        $notification->to([
            'broadcast' => $userToNotify,
            'email' => $emailToNotify,
        ])->push(
            [
                'title' => trans('iprofile::userapis.title.notifications.userCreated'),
                'message' => trans('iprofile::userapis.messages.notifications.userCreated',
                    [
                        'fullName' => $user->present()->fullname,
                        'firstName' => $user->first_name,
                        'lastName' => $user->last_name,
                        'createdAt' => $user->created_at,
                    ]
                ),
            ]
        );

        if (! $user->is_guest) {
            $notification->to([
                'email' => $user->email,
            ])->push(
                [
                    'title' => trans('iprofile::userapis.title.notifications.userCreated'),
                    'message' => trans('iprofile::userapis.messages.notifications.userCreatedToUser',
                        [
                            'fullName' => $user->present()->fullname,
                            'createdAt' => $user->created_at,
                        ]
                    ),
                ]
            );
        }
    }
}
