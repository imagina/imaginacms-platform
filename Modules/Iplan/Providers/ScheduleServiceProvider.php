<?php


namespace Modules\Iplan\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Console\Scheduling\Schedule;


class ScheduleServiceProvider extends ServiceProvider
{
    public function boot()
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
