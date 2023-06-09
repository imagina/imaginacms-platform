<?php

namespace Modules\Isearch\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface SearchRepository extends BaseRepository
{
    public function whereSearch($searchphrase);

    public function getItemsBy($params);

    public function getRepositoriesFromSetting($params);
}
