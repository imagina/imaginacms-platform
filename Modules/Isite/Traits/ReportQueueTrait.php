<?php

namespace Modules\Isite\Traits;

use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Events\AfterSheet;

use Modules\Isite\Entities\ReportQueue;

trait ReportQueueTrait
{
  public $userId;
  public $internalTraitLog = "ReportQueueTrait::";

  public function lockReport($reportName)
  {
    //Validate user session
    if (!$this->userId) return \Log::info("{$this->internalTraitLog} NO lockReport, missing userId");
    //Handle the report queue
    ReportQueue::updateOrCreate(
      ['report' => $reportName, 'user_id' => $this->userId],
      ['start_date' => now()]
    );
    //Log
    \Log::info("{$this->internalTraitLog}lockReport|Report:{$reportName}|User:{$this->userId}");
  }

  public function unlockReport($reportName)
  {
    //Validate user session
    if (!$this->userId) return \Log::info("{$this->internalTraitLog} NO unlockReport, missing userId");
    //Handle the report queue
    ReportQueue::updateOrCreate(
      ['report' => $reportName, 'user_id' => $this->userId],
      ['start_date' => null]
    );
    //Log
    \Log::info("{$this->internalTraitLog}unlockReport|Report:{$reportName}|User:{$this->userId}");
  }
}
