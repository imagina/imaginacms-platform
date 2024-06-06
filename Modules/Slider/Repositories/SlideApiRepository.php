<?php namespace Modules\Slider\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface SlideApiRepository extends BaseRepository
{
    public function index($page, $take, $filter, $include);

    public function create($data);
    
    public function show($id,$include);
    
    public function deleteBy($criteria, $params);
    
    public function updateBy($criteria, $data, $params);
    
}
