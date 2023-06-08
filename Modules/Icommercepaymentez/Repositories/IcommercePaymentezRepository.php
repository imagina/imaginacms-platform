<?php

namespace Modules\Icommercepaymentez\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface IcommercePaymentezRepository extends BaseRepository
{

	public function calculate($parameters,$conf);
	
}
