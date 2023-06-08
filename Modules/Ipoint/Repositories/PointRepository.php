<?php

namespace Modules\Ipoint\Repositories;

use Modules\Core\Icrud\Repositories\BaseCrudRepository;

interface PointRepository extends BaseCrudRepository
{

	public function calculate($parameters,$conf);

}
