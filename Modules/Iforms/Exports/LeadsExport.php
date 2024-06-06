<?php


namespace Modules\Iforms\Exports;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LeadsExport implements FromCollection,WithHeadings
{

  private $leads;

  public function __construct($leads)
  {
    $this->leads = $leads;
  }

  public function collection()
  {
    return $this->leads;
  }

  public function headings(): array
  {
    return [];
  }

}
