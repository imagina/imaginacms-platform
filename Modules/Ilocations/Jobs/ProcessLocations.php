<?php

namespace Modules\Ilocations\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessLocations implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 360;

    /**
     * Handle init
     */
    public function handle()
    {
        $baseClass = "\Modules\Ilocations\Database\Seeders";

        \Log::info('Ilocations: Jobs|ProcessLocations|IlocationsModuleTableSeeder|Running...');
        app($baseClass."\IlocationsModuleTableSeeder")->run();
        \Log::info('Ilocations: Jobs|ProcessLocations|IlocationsModuleTableSeeder|OK');

        \Log::info('Ilocations: Jobs|ProcessLocations|CountryTableSeeder|Running...');
        app($baseClass."\CountryTableSeeder")->run();
        \Log::info('Ilocations: Jobs|ProcessLocations|CountryTableSeeder|OK');

        \Log::info('Ilocations: Jobs|ProcessLocations|ProvinceTableSeeder|Running...');
        app($baseClass."\ProvinceTableSeeder")->run();
        \Log::info('Ilocations: Jobs|ProcessLocations|ProvinceTableSeeder|OK');

        \Log::info('Ilocations: Jobs|ProcessLocations|CityTableSeeder|Running...');
        app($baseClass."\CityTableSeeder")->run();
        \Log::info('Ilocations: Jobs|ProcessLocations|CityTableSeeder|OK');

        \Log::info('Ilocations: Jobs|ProcessLocations|GeozoneTableSeeder|Running...');
        app($baseClass."\GeozoneTableSeeder")->run();
        \Log::info('Ilocations: Jobs|ProcessLocations|GeozoneTableSeeder|OK');

        \Log::info('Ilocations: Jobs|ProcessLocations|FINISHED ;)');
    }
}
