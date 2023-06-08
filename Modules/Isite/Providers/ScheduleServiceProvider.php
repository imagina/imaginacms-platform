<?php

namespace Modules\Isite\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Artisan;

class ScheduleServiceProvider extends ServiceProvider
{
  public function boot()
  {
    $this->app->booted(function () {
      $schedule = $this->app->make(Schedule::class);
      $schedule->call(function () {
        Artisan::call('sitemap:generate');
      })->dailyAt('01:00');
    });
  }
}