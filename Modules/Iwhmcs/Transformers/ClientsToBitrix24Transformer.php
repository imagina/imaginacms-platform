<?php

namespace Modules\Iwhmcs\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class ClientsToBitrix24Transformer extends JsonResource
{
  public function toArray($request)
  {
    //Cases contact types by client group
    $casesContactTypesByClientGroup = [
      3 => 'SUPPLIER',//Partner Agencia
      6 => 'PARTNER',//Partner Freelance
      7 => 'CLIENT',//Cliente persona natural
      8 => '2',//Cliente Empresa (Default)
    ];

    return [
      'ID' => $this->when($this->contactBitrixId, $this->contactBitrixId),
      'ORIGINATOR_ID' => 'WHCMS',
      'ORIGIN_ID' => $this->when(isset($this->id), $this->id),
      'SOURCE_ID' => 'PARTNER',//Cliente existente
      'NAME' => $this->when(isset($this->firstname), $this->firstname),
      'LAST_NAME' => $this->when(isset($this->lastname), $this->lastname),
      'PHONE' => $this->when(isset($this->phonenumber), [
        ['VALUE' => $this->phonenumber, 'VALUE_TYPE' => 'WORK']
      ]),
      'EMAIL' => $this->when(isset($this->email), [
        ['VALUE' => $this->email, 'VALUE_TYPE' => 'WORK']
      ]),
      'ADDRESS' => $this->when(isset($this->address1), $this->address1),
      'ADDRESS_CITY' => $this->when(isset($this->city), $this->city),
      'ADDRESS_PROVINCE' => $this->when(isset($this->state), $this->state),
      'ADDRESS_COUNTRY' => $this->when(isset($this->country), $this->country),
      'UF_CRM_1620399795' => $this->when(isset($this->status), ($this->status == 'Active' ? 120 : 122)),
      'TYPE_ID' => $casesContactTypesByClientGroup[$this->groupid] ?? $casesContactTypesByClientGroup[8]
    ];
  }
}
