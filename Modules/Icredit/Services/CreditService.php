<?php

namespace Modules\Icredit\Services;

use Illuminate\Http\Request;
use Modules\Icredit\Entities\Credit;
use Modules\Icredit\Repositories\CreditRepository;

class CreditService
{
    public function __construct(

        CreditRepository $credit
    ) {
        $this->credit = $credit;
    }

    /**
     * CREATE A ITEM
     *
     * @param  Request  $request
     * @return mixed
     */
    public function create($data)
    {
        $needTobeCreated = true;
        if (isset($data['creditId'])) {
            $credit = $this->credit->find($data['creditId']);
            $needTobeCreated = false;
        } elseif (isset($data['credit']->id)) {
            $credit = $data['credit'];
            $needTobeCreated = false;
            if (! isset($credit->id)) {
                $needTobeCreated = true;
            }
        }

        if ($needTobeCreated) {
            $creditData = [
                'amount' => $data['amount'] ?? 0,
                'customer_id' => $data['customerId'] ?? null,
                'description' => $data['description'] ?? '',
                'status' => $data['status'] ?? 1,
                'related_id' => $data['relatedId'] ?? null,
                'related_type' => $data['relatedType'] ?? null,
            ];

            //Create credit
            $credit = $this->credit->create($creditData);
        }

        return $credit;
    }
}
