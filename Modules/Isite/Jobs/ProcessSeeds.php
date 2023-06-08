<?php

namespace Modules\Isite\Jobs;

use Illuminate\Bus\Queueable;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessSeeds implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  //Time out 1 minute
  public $timeout = 600;
  protected $params;

  public function __construct($params = [])
  {
    $this->params = $params;
  }

  public function handle()
  {
    $logTitle = "Isite:: Jobs|ProcessSeeds";

    foreach ($this->params["seeds"] as $seed) {
      \Log::info("$logTitle|$seed|Seeding");
      app($this->params["baseClass"] . "\\$seed")->run();
      \Log::info("$logTitle|$seed|Seeded");
    }
  }
}
