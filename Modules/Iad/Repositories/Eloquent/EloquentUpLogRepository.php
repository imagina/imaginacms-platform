<?php

namespace Modules\Iad\Repositories\Eloquent;

use Modules\Core\Icrud\Repositories\Eloquent\EloquentCrudRepository;
use Modules\Iad\Repositories\UpLogRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentUpLogRepository extends EloquentCrudRepository implements UpLogRepository
{
}
