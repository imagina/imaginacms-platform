<?php

namespace Modules\Icommercepayu\Repositories\Cache;

use Modules\Icommercepayu\Repositories\IcommercePayuRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheIcommercePayuDecorator extends BaseCacheDecorator implements IcommercePayuRepository
{
    public function __construct(IcommercePayuRepository $icommercepayu)
    {
        parent::__construct();
        $this->entityName = 'icommercepayu.icommercepayus';
        $this->repository = $icommercepayu;
    }


    public function calculate($parameters,$conf)
    {
        return $this->remember(function () use ($parameters,$conf) {
            return $this->repository->calculate($parameters, $conf);
        });
    }

    /**
     * List or resources
     *
     * @return mixed
     */
    public function encriptUrl($orderID,$transactionID,$currencyID)
    {
        return $this->remember(function () use ($orderID,$transactionID,$currencyID) {
            return $this->repository->encriptUrl($orderID,$transactionID,$currencyID);
        });
    }


     /**
     * List or resources
     *
     * @return mixed
     */
    public function decriptUrl($eUrl)
    {
        return $this->remember(function () use ($eUrl) {
            return $this->repository->decriptUrl($eUrl);
        });
    }
    
}
