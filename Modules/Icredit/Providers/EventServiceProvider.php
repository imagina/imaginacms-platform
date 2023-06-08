<?php

namespace Modules\Icredit\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

use Modules\Icredit\Events\Handlers\CheckCredit;
use Modules\Icommerce\Events\OrderWasCreated;
use Modules\Icommerce\Events\OrderWasUpdated;
use Modules\Icredit\Events\Handlers\CheckWithdrawalFundsRequest;
use Modules\Icredit\Events\WithdrawalFundsRequestWasAcepted;
use Modules\Icredit\Events\WithdrawalFundsRequestWasCreated;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        OrderWasCreated::class => [
            CheckCredit::class
        ],
        OrderWasUpdated::class => [
            CheckCredit::class
        ],
        WithdrawalFundsRequestWasAcepted::class => [
            CheckWithdrawalFundsRequest::class
        ],
    ];
}


