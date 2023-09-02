<?php

namespace Modules\Iwhmcs\Providers;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\ServiceProvider;

class ScheduleServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->booted(function () {
            $schedule = $this->app->make(Schedule::class);
            //Sync first the clients
            $schedule->call(function () {
                \Modules\Iwhmcs\Jobs\SyncClientsToBitrix24::dispatch();
                \Log::info('Iwhmcs::scheduled SyncClientsToBitrix24');
            })->timezone('America/Bogota')->dailyAt('07:00');
            //sync the due deals
            $schedule->call(function () {
                \Modules\Iwhmcs\Jobs\syncDueInvoicesItemsToBitrix::dispatch();
                \Log::info('Iwhmcs::scheduled syncDueInvoicesItemsToBitrix');
            })->timezone('America/Bogota')->dailyAt('08:00');
        });
    }
}
