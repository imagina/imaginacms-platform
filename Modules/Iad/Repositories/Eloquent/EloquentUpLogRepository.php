<?php

namespace Modules\Iad\Repositories\Eloquent;

use Modules\Core\Icrud\Repositories\Eloquent\EloquentCrudRepository;
use Modules\Iad\Repositories\UpLogRepository;

class EloquentUpLogRepository extends EloquentCrudRepository implements UpLogRepository
{
}
