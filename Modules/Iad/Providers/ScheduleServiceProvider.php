<?php

namespace Modules\Iad\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Console\Scheduling\Schedule;
use Modules\Iad\Jobs\UploadAds;

class ScheduleServiceProvider extends ServiceProvider
{
  public function boot()
  {
    if (!$this->app->runningInConsole()) {
  
      $this->app->booted(function () {
        $schedule = $this->app->make(Schedule::class);
    
        if (setting("iad::activateUploadsJob", null, false)) {
          $schedule->call(function () {
            \Modules\Iad\Jobs\UploadAds::dispatch();
          })->everyMinute();
      
          $schedule->call(function () {
            \Modules\Iad\Jobs\NotifyUploadAds::dispatch();
          })->dailyAt('20:00');
        }
    
    
      });
  
    }


  }

}
