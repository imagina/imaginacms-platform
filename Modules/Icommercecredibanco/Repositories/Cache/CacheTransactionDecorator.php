<?php

namespace Modules\Icommercecredibanco\Repositories\Cache;

use Modules\Core\Repositories\Cache\BaseCacheDecorator;
use Modules\Icommercecredibanco\Repositories\TransactionRepository;

class CacheTransactionDecorator extends BaseCacheDecorator implements TransactionRepository
{
    public function __construct(TransactionRepository $transaction)
    {
        parent::__construct();
        $this->entityName = 'icommercecredibanco.transactions';
        $this->repository = $transaction;
    }
}
