<?php

namespace Modules\Icommercecredibanco\Entities;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'icommercecredibanco__transactions';

    protected $fillable = [
        'order_id',
        'order_status',
        'type',
        'commerceId',
        'operationDate',
        'terminalCode',
        'operationNumber',
        'currency',
        'amount',
        'tax',
        'description',
        'errorCode',
        'errorMessage',
        'authorizationCode',
        'authorizationResult',
    ];
}
