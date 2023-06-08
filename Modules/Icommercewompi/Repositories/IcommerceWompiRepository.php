<?php

namespace Modules\Icommercewompi\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface IcommerceWompiRepository extends BaseRepository
{

    public function calculate($parameters,$conf);
    
}
