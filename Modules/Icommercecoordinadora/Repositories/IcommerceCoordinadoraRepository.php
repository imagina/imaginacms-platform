<?php

namespace Modules\Icommercecoordinadora\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface IcommerceCoordinadoraRepository extends BaseRepository
{

    public function calculate($parameters,$conf);
    
}
