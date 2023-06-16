<?php

namespace Modules\Iwhmcs\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductsToBitrix24Transformer extends JsonResource
{
    public function toArray($request)
    {
        //Instance column price name by product group
        $columnPriceByGroup = [
            23 => 'copSetupFeePrice', //Paginas WEB
            36 => 'copQuartelyPrice', //Admin. contenido
            21 => 'copMonthlyPrice', //Comunity manager
            34 => 'copSetupFeePrice', //Tiendas virtuales
            22 => 'copMonthlyPrice', //Posicionamiento natural
            37 => 'copMonthlyPrice', //Marketing digital
            40 => 'copSetupFeePrice', //Paginas web Negocios
        ];

        //Instance product price
        $productData = (array) $this->resource;
        //Get product price by group
        $productPriceByGroup = isset($columnPriceByGroup[$this->gid]) ? $productData[$columnPriceByGroup[$this->gid]] : null;
        //Get product price by pay type
        $productPriceByPayType = ($this->paytype == 'onetime') ? $this->copMonthlyPrice : $this->copAnnuallyPrice;

        //Data
        return [
            'ID' => $this->when($this->bitrixId, $this->bitrixId),
            'XML_ID' => $this->id,
            'CATALOG_ID' => '24',
            'SECTION_ID' => $this->productSectionBitrixId ?? '',
            'PRICE' => $productPriceByGroup ?? $productPriceByPayType,
            'CURRENCY_ID' => 'COP',
            'NAME' => trim($this->name).' - '.trim($this->groupName),
            'DESCRIPTION' => $this->description ?? '',
            'DESCRIPTION_TYPE' => 'html',
            'VAT_INCLUDED' => 'N',
        ];
    }
}
