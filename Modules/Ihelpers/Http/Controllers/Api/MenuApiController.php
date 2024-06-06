<?php

namespace Modules\Ihelpers\Http\Controllers\Api;

use Illuminate\Contracts\Cache\Repository;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Response;
use Modules\Menu\Repositories\MenuItemRepository;
use Modules\Menu\Services\MenuOrdener;

class MenuApiController extends Controller
{
  private $menuItem;

  public function __construct(MenuItemRepository $menuItem)
  {
    $this->menuItem = $menuItem;
  }

  /**
   * Return Menu
   *
   * @return mixed
   */
  public function show($id)
  {
    try {
      //Get Items Menu
      $items = $this->menuItem->getTreeForMenu($id);

      /*Function recursive for transform data*/
      function transformer($data, $children = false)
      {
        /*replace accents*/
        $search = explode(",","ç,æ,œ,á,é,í,ó,ú,à,è,ì,ò,ù,ä,ë,ï,ö,ü,ÿ,â,ê,î,ô,û,å,e,i,ø,u");
        $replace = explode(",","c,ae,oe,a,e,i,o,u,a,e,i,o,u,a,e,i,o,u,y,a,e,i,o,u,a,e,i,o,u");

        $response = [];
        //loop in all items
        foreach ($data as $itemMenu) {
          $title = $itemMenu->translations->first()->title;

          $response[$title] = [
            "title" => $title,
            "icon" => $itemMenu->icon ?? false,
            "to" => '/' . $urlTitle = str_replace($search, $replace, strtolower(join('-', explode(' ', $title)))),
            "children" => count($itemMenu->items) ?
              transformer($itemMenu->items, true) : []
          ];
        }
        //Return about if children or not
        return $children ? array_values($response) : $response;
      }

      ;

      //Response
      $response = ["data" => transformer($items)];
    } catch (\Exception $e) {
      //Message Error
      $status = 500;
      $response = [
        "errors" => $e->getMessage()
      ];
    }

    return response()->json($response, $status ?? 200);
  }
}
