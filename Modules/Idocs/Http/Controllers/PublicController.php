<?php

namespace Modules\Idocs\Http\Controllers;

use Illuminate\Http\Request;
use Log;
use Mockery\CountValidator\Exception;
use Modules\Core\Http\Controllers\BasePublicController;
use Modules\Idocs\Entities\DocumentUser;
use Modules\Idocs\Events\DocumentWasDownloaded;
use Modules\Idocs\Repositories\CategoryRepository;
use Modules\Idocs\Repositories\DocumentRepository;
use Route;
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;
use Illuminate\Support\Facades\Storage;

class PublicController extends BaseApiController
{
    private $category;
    private $document;

    public function __construct(DocumentRepository $document, CategoryRepository $category)
    {
        parent::__construct();
        $this->document = $document;
        $this->category = $category;
    }

    public function index(Request $request, $categorySlug = null)
    {

        $tpl = "idocs::frontend.index";
        $ttpl = "idocs.index";

        $category = null;
        
        if(!empty($categorySlug)){
          $params = ["filter" => ["field" => "slug", "locale" => \App::getLocale(), "private" => false]];
          $category = $this->category->getItem($categorySlug,json_decode(json_encode($params)));
        }
        
        if (view()->exists($ttpl)) $tpl = $ttpl;
        
        
        return view($tpl,compact('category'));
    }
  
  
  /**
   * GET A ITEM
   *
   * @param $criteria
   * @return mixed
   */
  public function show(Request $request, $documentId)
  {
    try {
      //Get Parameters from URL.
      $params = $this->getParamsRequest($request);
      
      //Request to Repository
      $document = $this->document->getItem($documentId, $params);
  
      if(isset($document->id)){
        if($document->private){
          $user = \Auth::user();
          if(isset($user->id)){
            $documentUser = DocumentUser::where('user_id', $user->id)->where('document_id',$document->id)->first();
            if(!isset($documentUser->id)) throw new Exception('Item not found',404);
          }else{
            throw new Exception('Item not found',404);
          }
        }
      }
  
      //Break if no found item
      if(!isset($document->id)) throw new Exception('Item not found',404);
  
      $type = $document->file->mimeType;
      
      $privateDisk = config('filesystems.disks.privatemedia');
      $mediaFilesPath = config('asgard.media.config.files-path');
      $path = $privateDisk["root"].$mediaFilesPath. $document->mediaFiles()->file->filename;
  
      event(new DocumentWasDownloaded($document));
      
      return response()->file($path, [
        'Content-Type' => $type,
        'Content-disposition' => 'attachment; filename="'.($document->mediaFiles()->file->filename).'"',
      ]);
      
    } catch (\Exception $e) {
      return abort(404);
    }
  }
  
  /**
   * GET A ITEM
   *
   * @param $criteria
   * @return mixed
   */
  public function showByKey(Request $request, $documentId, $key )
  {
    try {
      
      //Get Parameters from URL.
      $params = $this->getParamsRequest($request);
      
      //se intenta buscar el documento con el key que coincida con el key en la entidad document
      $params->filter->key = $key;
      //Request to Repository
      $document = $this->document->getItem($documentId, $params);
      //si se consigue el documento quiere decir que a pesar de ser privado, la solicitud se está haciendo con el key público del documento así que se da acceso al documento
   
      //si no se consigue con el key pricipal se intenta buscar de nuevo sin verificar el key principal para pasar a verificar si el key pertenece a un user del sistema asignado al documento
      if(!isset($document->id)){
        $params->filter->key = null;
        $document = $this->document->getItem($documentId, $params);
      
        if(isset($document->id)){
          if($document->private){
            $documentUser = DocumentUser::where('key', $key)->where('document_id',$document->id ?? null)->first();
            if(!$documentUser) throw new Exception('Item not found',404);
          }
        }
      }
      
      //Break if no found item
      if(!isset($document->id)) throw new Exception('Item not found',404);
      
      $type = $document->file->mimeType;
    
    
      $mediaFilesPath = config('asgard.media.config.files-path');
      $path = Storage::disk("privatemedia")->path($document->mediaFiles()->file->relativePath);

      event(new DocumentWasDownloaded($document,$key));
    
      return response()->file($path, [
        'Content-Type' => $type,
        'Content-disposition' => 'attachment; filename="'.($document->mediaFiles()->file->filename).'"',
      ]);
      
    } catch (\Exception $e) {
      return abort(404);
    }
  }
      
    public function indexPrivate(Request $request, $categorySlug = null)
    {

        $categories = $this->category->getItemsBy(json_decode(json_encode(['filter' => ['private' => 0], 'page' => $request->page ?? 1, 'take' => setting('idocs::docs-per-page'), 'include' => ['children']])));
        
        $tpl = "idocs::frontend.index-private";
        $ttpl = "idocs.index-private";
  
      $category = null;
  
      if(!empty($categorySlug)){
        $params = ["filter" => ["field" => "slug", "locale" => \App::getLocale(), "private" => true]];
        $category = $this->category->getItem($categorySlug,json_decode(json_encode($params)));
      }
  
      
      if (view()->exists($ttpl)) $tpl = $ttpl;
        return view($tpl, compact('categories','category'));
    }

    public function category($categorySlug)
    {
        $category = $this->category->findBySlug($categorySlug);

        if($category->private && !\Auth::user()) return redirect()->route('login');

        $documents = $this->document->whereCategory($category->id);
        $tpl = "idocs::frontend.categories";
        $ttpl = "idocs.categories";

        if (view()->exists($ttpl)) $tpl = $ttpl;
        return view($tpl, compact('documents', 'category'));
    }

    public function search(Request $request)
    {
        try {
            $searchphrase = $request->input('q');
            if (!$searchphrase) throw new \Exception('Item not found', 404);
            $documents = $this->document->getItemsBy(json_decode(json_encode(['filter' => ['identification' => $searchphrase['identification'],'key'=>$searchphrase['key']??'0','status'=>1], 'page' => $request->page ?? 1, 'take' => setting('idocs::docs-per-page'), 'include' => ['user']])));

        } catch (\Exception $e) {
            $searchphrase = null;
            $documents = null;
        }

        $tpl = "idocs::frontend.search";
        $ttpl = "idocs.search";

        if (view()->exists($ttpl)) $tpl = $ttpl;
        return view($tpl, compact('documents', 'searchphrase'));

    }

}