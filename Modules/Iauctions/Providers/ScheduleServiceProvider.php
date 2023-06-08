<?php

namespace Modules\Iauctions\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Console\Scheduling\Schedule;


class ScheduleServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->booted(function () {

            $schedule = $this->app->make(Schedule::class);

           
            $schedule->call(function () {
                \Modules\Iauctions\Jobs\CheckDaysToStartAuction::dispatch();
            })->daily();
           
            
            $schedule->call(function () {
                \Modules\Iauctions\Jobs\CheckStatusInitAuction::dispatch();
            })->everyMinute();
           
           
            $schedule->call(function () {
                \Modules\Iauctions\Jobs\CheckHoursToFinishAuction::dispatch();
            })->everyMinute();
           
            
            $schedule->call(function () {
                \Modules\Iauctions\Jobs\CheckStatusFinishAuction::dispatch();
            })->everyMinute();
            
                
        });

    }
}
