<?php

namespace Modules\Isearch\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use Modules\Iblog\Entities\Post;
use Modules\Isearch\Repositories\Collection;
use Modules\Isearch\Repositories\SearchRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Laracasts\Presenter\PresentableTrait;
use Modules\Isearch\Transformers\SearchItemTransformer;
use Illuminate\Support\Str;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Container\Container;

class EloquentSearchRepository extends EloquentBaseRepository implements SearchRepository
{

  public function whereSearch($searchphrase)
  {
    return $this->posts->where('title', 'LIKE', "%{$searchphrase}%")
      ->orWhere('description', 'LIKE', "%{$searchphrase}%")
      ->orderBy('created_at', 'DESC')->paginate(12);
  }

  public function getItemsBy($params)
  {
    $results = Collect();
    $filter = $params->filter;
    $minCharactersSearch = setting("isearch::minSearchChars");
    
    $params->filter->minCharactersSearch = setting("isearch::minSearchChars",null,3);
    
    $take = $params->take;
    $page = $params->page;
    $params->take = $params->page = 0;
    
    if (isset($filter->repositories)) {
      !is_array($filter->repositories) ? $filter->repositories = [$filter->repositories] : false;
      foreach ($filter->repositories as $repository) {
        try {
          $repository = app($repository);
          $items = $repository->getItemsBy($params);
          $results = $results->concat($items);
        } catch (\Exception $e) {
          \Log::info("Isearch::SearchRepository | getItemsBy error:".$e->getMessage());
        }
      }
      $words = explode(' ', trim($filter->search));
      

      foreach($results as &$result){
        $result->coincidences=0;
        foreach ($words as $index => $word) {
          if(strlen($word)>=$minCharactersSearch){
            $pos = strpos(Str::slug($result->title ?? $result->name ?? ""),Str::slug($word));
            if($pos !== false){
              $result->coincidences+=1;
            }//if pos
            $pos = strpos(Str::slug($result->description ?? $result->body ?? ""),Str::slug($word));
            if($pos !== false){
              $result->coincidences+=1;
            }//if pos
          }//if str len words
        }//foreach words
      }//foreach collection
      
      //Sort by coincidences
      $results=$results->sortByDesc("coincidences");

      $results = $this->getPaginator(request(),$results, $page, $take);
      return $results;
    }//searchItems
    
  }
  
  private function customPaginate( $results, $showPerPage)
  {
    $pageNumber = Paginator::resolveCurrentPage('page');
    
    $totalPageNumber = $results->count();
    
    return $this->paginator($results->forPage($pageNumber, $showPerPage), $totalPageNumber, $showPerPage, $pageNumber, [
      'path' => Paginator::resolveCurrentPath(),
      'pageName' => 'page',
    ]);
    
  }
  
  /**
   * Create a new length-aware paginator instance.
   *
   * @param  \Illuminate\Support\Collection  $items
   * @param  int  $total
   * @param  int  $perPage
   * @param  int  $currentPage
   * @param  array  $options
   * @return \Illuminate\Pagination\LengthAwarePaginator
   */
  protected static function paginator($items, $total, $perPage, $currentPage, $options)
  {
    return Container::getInstance()->makeWith(LengthAwarePaginator::class, compact(
      'items', 'total', 'perPage', 'currentPage', 'options'
    ));
  }
  
  private function getPaginator($request, $items, $page, $take)
  {
    
    $total = count($items); // total count of the set, this is necessary so the paginator will know the total pages to display
    $offset = ($page - 1) * $take; // get the offset, how many items need to be "skipped" on this page
  
    $items = $items->forPage($page, $take);
    return new LengthAwarePaginator($items, $total, $take, $page, [
      'path' => $request->url(),
      'query' => $request->query()
    ]);
  }
}
