<?php

namespace Modules\Iplan\Providers;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\ServiceProvider;

class ScheduleServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->app->booted(function () {
            $schedule = $this->app->make(Schedule::class);

            $schedule->call(function () {
                \Modules\Iplan\Jobs\NotifyExpiredSubscriptions::dispatch();
            })->dailyAt('20:00');

            $schedule->call(function () {
                \Modules\Iplan\Jobs\FinishedSubscriptions::dispatch();
            })->everyMinute();
        });
    }
}
