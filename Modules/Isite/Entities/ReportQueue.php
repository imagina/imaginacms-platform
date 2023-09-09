<?php

namespace Modules\Isite\Entities;

use Modules\Core\Icrud\Entities\CrudModel;

class ReportQueue extends CrudModel
{
  protected $table = 'isite__report_queue';
  public $transformer = 'Modules\Isite\Transformers\ReportQueueTransformer';
  public $repository = 'Modules\Isite\Repositories\ReportQueueRepository';
  public $requestValidation = [
    'create' => 'Modules\Isite\Http\Requests\CreateReportQueueRequest',
    'update' => 'Modules\Isite\Http\Requests\UpdateReportQueueRequest',
  ];
  //Instance external/internal events to dispatch with extraData
  public $dispatchesEventsWithBindings = [
    //eg. ['path' => 'path/module/event', 'extraData' => [/*...optional*/]]
    'created' => [],
    'creating' => [],
    'updated' => [],
    'updating' => [],
    'deleting' => [],
    'deleted' => []
  ];
  protected $fillable = [
    'report',
    'user_id',
    'start_date'
  ];
}
