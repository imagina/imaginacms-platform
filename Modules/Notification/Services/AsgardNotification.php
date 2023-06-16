<?php

namespace Modules\Notification\Services;

use Modules\Notification\Events\BroadcastNotification;
use Modules\Notification\Repositories\NotificationRepository;
use Modules\User\Contracts\Authentication;

final class AsgardNotification implements Notification
{
    /**
     * @var NotificationRepository
     */
    private $notification;

    /**
     * @var Authentication
     */
    private $auth;

    /**
     * @var int
     */
    private $userId;

    public function __construct(NotificationRepository $notification, Authentication $auth)
    {
        $this->notification = $notification;
        $this->auth = $auth;
    }

    /**
     * Push a notification on the dashboard
     *
     * @param  string  $title
     * @param  string  $message
     * @param  string  $icon
     * @param  string|null  $link
     */
    public function push($title, $message, $icon, $link = null)
    {
        $notification = $this->notification->create([
            'user_id' => $this->userId ?: $this->auth->id(),
            'icon_class' => $icon,
            'link' => $link,
            'title' => $title,
            'message' => $message,
        ]);

        if (true === config('asgard.notification.config.real-time', false)) {
            $this->triggerEventFor($notification);
        }
        $this->toFirebase($notification);
    }

    /**
     * Trigger the broadcast event for the given notification
     */
    private function triggerEventFor(\Modules\Notification\Entities\Notification $notification)
    {
        broadcast(new BroadcastNotification($notification))->toOthers();
    }

    private function toFirebase(\Modules\Notification\Entities\Notification $notification)
    {
        try {
            \Log::info('Notification push');
            fcm()->toTopic('notification.new.'.$notification->user_id) // $topic must an string (topic name)
            ->priority('normal')
                ->timeToLive(0)
                ->data([
                    'body' => $notification->message,
                ])
                ->notification([
                    'title' => $notification->title,
                    'body' => $notification->message,
                    'link' => $notification->link,
                    'image' => setting('isite::logo1'),
                ])
                ->send();
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
        }
    }

    /**
     * Set a user id to set the notification to
     *
     * @param  int  $userId
     * @return $this
     */
    public function to($userId)
    {
        $this->userId = $userId;

        return $this;
    }
}
