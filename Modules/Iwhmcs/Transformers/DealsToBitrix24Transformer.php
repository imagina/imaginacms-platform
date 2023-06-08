<?php

namespace Modules\Iwhmcs\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class DealsToBitrix24Transformer extends JsonResource
{
  public function toArray($request)
  {
    return [
      "ID" => $this->bitrixId,
      "TITLE" => "{$this->id}-{$this->dealName}",
      "STAGE_ID" => "UC_2O40XC",//"WON",
      "CONTACT_ID" => $this->bitrixContactId,
      "OPENED" => "Y",
      "CURRENCY_ID" => "COP",
      "BEGINDATE" => (isset($this->firstInvoice->datepaid) && ($this->firstInvoice->datepaid != '0000-00-00 00:00:00')) ?
        $this->firstInvoice->datepaid : $this->firstInvoice->date,
      "CLOSEDATE" => ($this->lastInvoice->datepaid && ($this->lastInvoice->datepaid != '0000-00-00 00:00:00')) ?
        $this->lastInvoice->datepaid : $this->lastInvoice->date,
      "DATA_CREATE" => $this->firstInvoice->date,
      //"ORIGIN_ID" => $this->id,
    ];
  }
}
