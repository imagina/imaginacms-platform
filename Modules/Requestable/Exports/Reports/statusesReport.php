<?php

namespace Modules\Requestable\Exports\Reports;

class statusesReport
{
 
  private $requestableExport;
  
  /**
   * Position of Status History fields in table
   * Values: first|end
   */
  private $position = "first"; 

  public function __construct($requestableExport)
  {
    $this->requestableExport = $requestableExport;
  }

  /**
   * Heading to Report
   */
  public function getHeading()
  {

    $headingFields = [
        trans('requestable::requestables.table.id'),
        trans('requestable::requestables.table.requested by'),
        trans('requestable::requestables.table.created by'),
    ];

    //Add Extra Fields
    if($this->requestableExport->showExtraFields)
      $headingFields = $this->requestableExport->addFieldsToHeading($headingFields);

    //Add Status Columns
    $statusColumns = [
      trans('requestable::requestables.table.status old'),
      trans('requestable::requestables.table.status new'),
      trans('requestable::requestables.table.date'),
      trans('requestable::requestables.table.history created by'),
    ];

    $headingFields = $this->setPositionData($headingFields,$statusColumns);
   
    return $headingFields;

  }

  /**
   * Map (Row) to Report
   */ 
  public function getMap($item)
  {

     // Base Item Fields
    
     $baseItem = [
      $item->id ?? null,
      $item->requestedBy ? $item->requestedBy->present()->fullname: null,
      $item->createdByUser->present()->fullname ?? null
    ]; 

    //Add Extra Fields
    if($this->requestableExport->showExtraFields)
      $baseItem = $this->requestableExport->addFieldsToItem($item,$baseItem);

    //Add Statuses History
    $baseItem = $this->addStatusesHistory($item,$baseItem);
  
    return $baseItem;
    
  }

  /**
   * Add statuses to the item
   */
  public function addStatusesHistory($item,$baseItem)
  {
    
    //$itemStatusHistory = $item->statusHistory;
    $itemStatusHistory = $item->statusHistory()->orderBy('created_at','desc')->get();
     
    $statusesTotal = $itemStatusHistory->count();
    if($statusesTotal>0){

      $rows = [];
      foreach ($itemStatusHistory as $key => $statusHistory) {
        
        //the status not deleted yet
        if(isset($statusHistory->status)){
          $copyBase = $baseItem;

          // Because order is Desc
          if($key<($statusesTotal-1))
            $statusPrevious = $itemStatusHistory[$key+1];
          else
            $statusPrevious = null;
           
          //Set final data
          $statusData = [
            $statusPrevious->status->title ?? '-----',
            $statusHistory->status->title ?? '-----',
            $statusHistory->created_at->format('d-m-Y || H:i:s'),
            //$statusHistory->created_at->format('H:i:s'),
            $statusHistory->createdByUser->present()->fullname ?? '-----'
          ];

          $copyBase = $this->setPositionData($copyBase,$statusData);

          //Save Final rows
          $rows[] = $copyBase;
        }

      }

      //Set baseitem to return
      $baseItem = $rows;

    }else{
      
      //Not status history - Set item with the first status (when the request was created)
      $statusData = [
        '', //Not old status
        $item->status->title ?? '-----',
        //verify that the status exists because they may have deleted the status
        $item->status ? $item->created_at->format('d-m-Y') : '-----',
        $item->status ? $item->created_at->format('H:i:s') : '-----',
        $item->status ? $item->createdByUser->present()->fullname : '-----',
      ];

      $baseItem = $this->setPositionData($baseItem,$statusData);
     
    }

    return $baseItem;
  }

  /**
   * Set Position of Status History fields in table
   */
  public function setPositionData($baseData, $newData)
  {

    $total = (count($baseData));

    if($this->position=="first")
      array_splice($baseData, 0, 0, $newData);

    if($this->position=="end")
      array_splice($baseData, $total, 0, $newData);
     
   
    return $baseData;

  }

}
