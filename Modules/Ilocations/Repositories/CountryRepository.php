<?php

namespace Modules\Ilocations\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface CountryRepository extends BaseRepository
{
  public function findByIso2($iso2);
  public function index($page, $take, $filter, $include, $fields);
  public function getItemsBy($params);
  public function getItem($criteria, $params);
}
