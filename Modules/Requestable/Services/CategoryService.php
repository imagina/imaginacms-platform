<?php


namespace Modules\Requestable\Services;

use Modules\Requestable\Repositories\CategoryRepository;


class CategoryService
{
 
  private $categoryRepository;
  
  public function __construct(
    CategoryRepository $categoryRepository
  ){
   
    $this->categoryRepository = $categoryRepository;
  }
  
  /**
   * Chek if a category is Internal
  */
  public function isInternal($criteria,$params = null){

    $model = $this->categoryRepository->getItem($criteria, $params);

    //Throw exception if no found item
    if (!$model) throw new \Exception('Item not found', 204);

    if($model->internal)
      return true;

    return false;

  }


  
  
}
