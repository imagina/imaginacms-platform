<?php

namespace Modules\Core\Icrud\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Support\Traits\AuditTrait;
use Modules\Core\Icrud\Traits\hasEventsWithBindings;

class CrudModel extends Model
{
  use AuditTrait, hasEventsWithBindings;
}
