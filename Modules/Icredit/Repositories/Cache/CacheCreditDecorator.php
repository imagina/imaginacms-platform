<?php

namespace Modules\Icredit\Repositories\Cache;

use Modules\Core\Repositories\Cache\BaseCacheDecorator;
use Modules\Icredit\Repositories\CreditRepository;

class CacheCreditDecorator extends BaseCacheDecorator implements CreditRepository
{
    public function __construct(CreditRepository $credit)
    {
        parent::__construct();
        $this->entityName = 'icredit.credits';
        $this->repository = $credit;
    }

    public function calculate($parameters, $conf)
    {
        return $this->remember(function () use ($parameters, $conf) {
            return $this->repository->calculate($parameters, $conf);
        });
    }
}
