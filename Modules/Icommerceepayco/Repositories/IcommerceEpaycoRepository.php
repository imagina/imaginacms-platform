<?php

namespace Modules\Icommerceepayco\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface IcommerceEpaycoRepository extends BaseRepository
{

	public function calculate($parameters,$conf);
   
    
}
