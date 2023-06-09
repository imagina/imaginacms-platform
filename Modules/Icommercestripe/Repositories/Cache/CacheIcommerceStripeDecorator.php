<?php

namespace Modules\Icommercestripe\Repositories\Cache;

use Modules\Core\Repositories\Cache\BaseCacheDecorator;
use Modules\Icommercestripe\Repositories\IcommerceStripeRepository;

class CacheIcommerceStripeDecorator extends BaseCacheDecorator implements IcommerceStripeRepository
{
    public function __construct(IcommerceStripeRepository $icommercestripe)
    {
        parent::__construct();
        $this->entityName = 'icommercestripe.icommercestripes';
        $this->repository = $icommercestripe;
    }

    public function calculate($parameters, $conf)
    {
        return $this->remember(function () use ($parameters, $conf) {
            return $this->repository->calculate($parameters, $conf);
        });
    }
}
