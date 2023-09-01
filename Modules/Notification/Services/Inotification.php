<?php

namespace Modules\Notification\Services;

interface Inotification
{
    /**
     * Push a notification on the dashboard
     *
     * @param  string  $title
     * @param  string  $message
     * @param  string  $icon
     * @param  string|null  $link
     */
    public function push($params = []);

    /**
     * @param  varchar  $recipient
     * @return $this
     */
    public function to($recipient);

    /**
     * @param string|Provider[object] $provider
     * @return $this
     */
    public function provider($provider);

    /**
     * @param  string  $type
     * @return $this
     */
    public function type($type);
}
