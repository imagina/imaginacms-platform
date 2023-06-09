<?php

namespace Modules\Ibooking\Providers;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\ServiceProvider;

class ScheduleServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->booted(function () {
            $schedule = $this->app->make(Schedule::class);

            $schedule->call(function () {
                \Modules\Ibooking\Jobs\CheckStatusReservations::dispatch();
            })->everyMinute();
        });
    }
}
