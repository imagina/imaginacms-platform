<?php

namespace Modules\Imeeting\Repositories\Eloquent;

use Modules\Core\Icrud\Repositories\Eloquent\EloquentCrudRepository;
use Modules\Imeeting\Repositories\MeetingRepository;

class EloquentMeetingRepository extends EloquentCrudRepository implements MeetingRepository
{
}
