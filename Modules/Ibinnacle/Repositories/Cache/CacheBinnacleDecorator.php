<?php

namespace Modules\Ibinnacle\Repositories\Cache;

use Modules\Ibinnacle\Repositories\BinnacleRepository;
use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;

class CacheBinnacleDecorator extends BaseCacheCrudDecorator implements BinnacleRepository
{
    public function __construct(BinnacleRepository $binnacle)
    {
        parent::__construct();
        $this->entityName = 'ibinnacle.binnacles';
        $this->repository = $binnacle;
    }
}
