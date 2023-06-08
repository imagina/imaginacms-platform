<?php

namespace Modules\Icommerceopenpay\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface IcommerceOpenpayRepository extends BaseRepository
{

	public function calculate($parameters,$conf);
	
}
