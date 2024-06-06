<?php namespace Modules\Slider\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface SliderApiRepository extends BaseRepository
{
  public function getItemsBy($params);
  
  public function updateBy($criteria, $data, $params);
  
  public function index($page, $take, $filter, $include);
  
  public function getItem($criteria, $params);
  
  public function show($id, $include);

  public function create($data);

  public function deleteBy($criteria, $params);

}
