<?php

namespace Modules\Icommerceflatrate\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface IcommerceFlatrateRepository extends BaseRepository
{
    public function calculate($parameters, $conf);
}
