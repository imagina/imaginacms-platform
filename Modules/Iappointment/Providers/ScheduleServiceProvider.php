<?php


namespace Modules\Iappointment\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Console\Scheduling\Schedule;


class ScheduleServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->booted(function () {
            $schedule = $this->app->make(Schedule::class);
            $schedule->call(function () {
                \Modules\Iappointment\Jobs\AssignAppointment::dispatch();
            })
                ->everyMinute();

            $schedule->call(function () {
                \Modules\Iappointment\Jobs\MarkExpiredAppointments::dispatch();
            })
                ->everyMinute();
                //->dailyAt('20:00');

        });

    }
}
