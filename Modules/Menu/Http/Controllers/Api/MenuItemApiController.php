<?php

namespace Modules\Menu\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Menu\Http\Requests\CreateMenuItemRequest;

use Modules\Menu\Repositories\MenuItemRepository;
use Modules\Menu\Entities\Menu;

use Modules\Menu\Transformers\MenuitemTransformer;

// Base Api
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;

use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Menu\Services\MenuItemUriGenerator;

class MenuItemApiController extends BaseApiController
{
  private $menuitem;
  private $menu;
  private $menuItemUriGenerator;

  public function __construct(MenuItemRepository $menuitem, Menu $menu, MenuItemUriGenerator $menuItemUriGenerator)
  {
    $this->menuitem = $menuitem;
    $this->menu = $menu;
    $this->menuItemUriGenerator = $menuItemUriGenerator;
  }

  /**
   * GET ITEMS
   *
   * @return mixed
   */
  public function index(Request $request)
  {
    try {
      //Get Parameters from URL.
      $params = $this->getParamsRequest($request);
      //Request to Repository
      $menuitems = $this->menuitem->getItemsBy($params);
      //Response
      $response = ['data' => MenuitemTransformer::collection($menuitems)];
      //If request pagination add meta-page
      $params->page ? $response["meta"] = ["page" => $this->pageTransformer($menuitems)] : false;
    } catch (\Exception $e) {
      $status = $this->getStatusError($e->getCode());
      $response = ["errors" => $e->getMessage()];
    }
    //Return response
    return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
  }

  /**
   * GET A ITEM
   *
   * @param $criteria
   * @return mixed
   */
  public function show($criteria, Request $request)
  {
    try {
      //Get Parameters from URL.
      $params = $this->getParamsRequest($request);
      //Request to Repository
      $menuitem = $this->menuitem->getItem($criteria, $params);
      //Break if no found item
      if (!$menuitem) throw new \Exception('Item not found', 204);
      //Response
      $response = ["data" => new MenuitemTransformer($menuitem)];
      //If request pagination add meta-page
      $params->page ? $response["meta"] = ["page" => $this->pageTransformer($dataEntity)] : false;
    } catch (\Exception $e) {
      $status = $this->getStatusError($e->getCode());
      $response = ["errors" => $e->getMessage()];
    }
    //Return response
    return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
  }

  /**
   * CREATE A ITEM
   *
   * @param Request $request
   * @return mixed
   */
  public function create(Request $request)
  {
    \DB::beginTransaction();
    try {
      $data = $request->input('attributes') ?? [];//Get data
      //Validate Request
      $this->validateRequestApi(new CreateMenuItemRequest($data));
      //Create item
      $product = $this->menuitem->create($data);
      //Response
      $response = ["data" => new MenuitemTransformer($product)];
      \DB::commit(); //Commit to Data Base
    } catch (\Exception $e) {
      \DB::rollback();//Rollback to Data Base
      $status = $this->getStatusError($e->getCode());
      $response = ["errors" => $e->getMessage()];
    }
    //Return response
    return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
  }

  /**
   * UPDATE ITEM
   *
   * @param $criteria
   * @param Request $request
   * @return mixed
   */
  public function update($criteria, Request $request)
  {
    \DB::beginTransaction(); //DB Transaction
    try {
      $data = $request->input('attributes') ?? [];//Get data
      $params = $this->getParamsRequest($request);//Get Parameters from URL.
      $menu = $this->menu->find($data['menu_id']);//Get menu
      $languages = LaravelLocalization::getSupportedLanguagesKeys();
      if (!$menu) throw new \Exception('Item not found', 204);//Break if no found item

      //Validate Link type
      foreach ($languages as $lang) {
        if ($data['link_type'] === 'page' && !empty($data['page_id'])) {
          $data[$lang]['uri'] = $this->menuItemUriGenerator->generateUri($data['page_id'], $data['parent_id'], $lang);
        }
      }

      //Validate Parent ID
      if (!isset($data['parent_id'])) $data['parent_id'] = $this->menuitem->getRootForMenu($menu->id)->id;

      //Request to Repository
      $this->menuitem->updateBy($criteria, $data, $params);
      //Response
      $response = ["data" => 'Item Updated'];
      \DB::commit();//Commit to DataBase
    } catch (\Exception $e) {
      \DB::rollback();//Rollback to Data Base
      $status = $this->getStatusError($e->getCode());
      $response = ["errors" => $e->getMessage()];
    }
    //Return response
    return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
  }

  /**
   * DELETE A ITEM
   *
   * @param $criteria
   * @return mixed
   */
  public function delete($criteria, Request $request)
  {
    \DB::beginTransaction();
    try {
      //Get params
      $params = $this->getParamsRequest($request);
      //call Method delete
      $this->menuitem->deleteBy($criteria, $params);
      //Response
      $response = ["data" => "Item deleted"];
      \DB::commit();//Commit to Data Base
    } catch (\Exception $e) {
      \DB::rollback();//Rollback to Data Base
      $status = $this->getStatusError($e->getCode());
      $response = ["errors" => $e->getMessage()];
    }
    //Return response
    return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
  }

  public function updateItems(Request $request)
  {
    try {
      //Get Parameters from URL.
      $params = $this->getParamsRequest($request);
      $data = $request->input('attributes') ?? [];//Get data
      //Request to Repository
      $dataEntity = $this->menuitem->getItemsBy($params);
      $crterians = $dataEntity->pluck('id');
      $dataEntity = $this->menuitem->updateItems($crterians, $data);
      //Response
      $response = ["data" => MenuitemTransformer::collection($dataEntity)];
      //If request pagination add meta-page
      $params->page ? $response["meta"] = ["page" => $this->pageTransformer($dataEntity)] : false;
    } catch (\Exception $e) {
      \Log::error($e);
      $status = $this->getStatusError($e->getCode());
      $response = ["errors" => $e->getMessage()];
    }
    //Return response
    return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
  }

  public function deleteItems(Request $request)
  {
    try {
      //Get Parameters from URL.
      $params = $this->getParamsRequest($request);
      //Request to Repository
      $dataEntity = $this->menuitem->getItemsBy($params);
      $crterians = $dataEntity->pluck('id');
      $this->menuitem->deleteItems($crterians);
      //Response
      $response = ["data" => "Items deleted"];
    } catch (\Exception $e) {
      \Log::error($e);
      $status = $this->getStatusError($e->getCode());
      $response = ["errors" => $e->getMessage()];
    }
    //Return response
    return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
  }

  public function updateOrderner(Request $request)
  {
    \DB::beginTransaction();
    try {
      $params = $this->getParamsRequest($request);
      $data = $request->input('attributes');
      //Update data
      $newData = $this->menuitem->updateOrders($data);
      //Response
      $response = ['data' => 'updated items'];
      \DB::commit(); //Commit to Data Base
    } catch (\Exception $e) {
      \DB::rollback();//Rollback to Data Base
      $status = $this->getStatusError($e->getCode());
      $response = ["errors" => $e->getMessage()];
    }
    return response()->json($response, $status ?? 200);
  }

}
