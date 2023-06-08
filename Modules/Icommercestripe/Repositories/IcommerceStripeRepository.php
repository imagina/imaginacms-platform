<?php

namespace Modules\Icommercestripe\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface IcommerceStripeRepository extends BaseRepository
{

	public function calculate($parameters,$conf);
	
}
