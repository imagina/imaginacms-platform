<?php


namespace Modules\Iforms\Services;

use Modules\Iforms\Exports\LeadsExport;

class LeadsExportService
{
  public function exportFile ($data)
  {
    $values = [];
    foreach ($data as $item){
      $values[] = json_decode($item->values);
    }
    $response = [];
    foreach ($values as $indexValue => $value) {
      foreach ($value as $indexField => $field) {
        $response[$indexValue][$indexField] = $field->model;
      }
    }
    //return $response;
    return \Excel::store(new LeadsExport( collect($response) ), 'leads.xlsx');
  }
}
