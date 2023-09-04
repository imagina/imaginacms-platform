<?php


namespace Modules\Iblog\Services;

use Illuminate\Http\Request;
use Modules\Isite\Services\AiService;
use Modules\Iblog\Entities\Category;
use Modules\Iblog\Entities\Post;

class BlogContentAi
{
  public $aiService;
  private $log = "Iblog: Services|BlogContentAi|";
  private $postRepository;
  private $categoryRepository;

  private $maxAttempts;
  private $postQuantity;

  function __construct($postQuantity = 4)
  {
    $this->aiService = new AiService();
    $this->maxAttempts = (int)setting("isite::n8nMaxAttempts", null, 3);
    $this->postQuantity = $postQuantity;
    $this->postRepository = app("Modules\Iblog\Repositories\PostRepository");
    $this->categoryRepository = app("Modules\Iblog\Repositories\CategoryRepository");
  }

  public function getPosts($quantity = 2)
  { 
    \Log::info($this->log."getPosts|INIT");

    //instance the prompt to generate the posts
    $prompt = "Contenido para post de blog que seran usados en un sitio WEB con los siguientes atributos ";
    //Instance attributes
    $prompt .= $this->aiService->getStandardPrompts(
      ["title", "description", "summary", "slug", "category_id", "tags"],
      ["categories" => Category::get()]
    );
    //Call IA Service
    $response = $this->aiService->getContent($prompt, $quantity);
    \Log::info($this->log."getPosts|END");
    //Return response
    return $response;
  }

  /**
  * Principal
  */
  public function startProcesses()
  {

    \Log::info($this->log."startProcesses");

    //Show infor in log
    //showDataConnection();

    $newData = $this->getNewData();
    if(!is_null($newData)){

      $newPostsIds = $this->createPosts($newData);
      if(count($newPostsIds)){
        //\Log::info(json_encode($newPostsIds));
        $this->deleteOldPosts($newPostsIds);
      }
      
    }

  }

  /**
  * Get the New Data
  */
  public function getNewData()
  {
    
    $newData = null;

    //Total of posts depending of the (instalation or tenant etc)
    $params = [] ;
    $totalPost = $this->postRepository->getItemsBy(json_decode(json_encode($params)));
    $postQuantity = count($totalPost)>0 ? count($totalPost) : $this->postQuantity;
    
    $attempts = 0;
    do {
      \Log::info($this->log."getNewData|Attempt:".($attempts+1)."/Max:".$this->maxAttempts);
      $newData = $this->getPosts($postQuantity);
      if(is_null($newData)){
        $attempts++;
      }else{
        if(isset($newData[0]['es']) && isset($newData[0]['en']))
          break;
        else
          $attempts++;
      }
    }while($attempts < $this->maxAttempts);

    return $newData;
  }

  /**
  * Post to Create
  */
  public function createPosts($posts)
  {

    \Log::info($this->log."createPosts");

    $newPostsIds = [];
    foreach ($posts as $key => $post) {

      if(isset($post['category_id']) && is_numeric($post['category_id'])){

        \Log::info($this->log."createPosts|Category Id:".$post['category_id']);

        //A pesar que se le envia las categorias existen, a veces trae ids q no existen en el sitio
        $category = $this->categoryRepository->getItem($post['category_id']);
        if(!is_null($category)){

          // Image Process
          if(isset($post['image']) && isset($post['image'][0])){
            $file = $this->aiService->saveImage($post['image'][0]);
            $post['medias_single']['mainimage'] = $file->id;
            $post['medias_single']['secondaryimage'] = $file->id;
          }

          //Delete data from AI
          if(isset($post['tags'])) unset($post['tags']);
          if(isset($post['image'])) unset($post['image']);

          //Default values
          $post['user_id'] = 1;
          $post['status'] = 2; //Published

          $newPost = $this->postRepository->create($post);

          //Save new posts
          array_push($newPostsIds,$newPost->id);

        }
         
      }

    }

    return $newPostsIds;
   
  }

  /**
   * Delete old Posts
   */
  public function deleteOldPosts($newPostsIds)
  {

    \Log::info($this->log."deleteOldPosts");

    $params = [
      "include" => [],
      "filter" => [
        'exclude' => $newPostsIds
      ]
    ];
    $posts = $this->postRepository->getItemsBy(json_decode(json_encode($params)));
    
    if(count($posts)>0){
      foreach ($posts as $key => $post) {
        $post->delete();
      }
    }

  }

}
