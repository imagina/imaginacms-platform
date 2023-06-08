<?php

namespace Modules\Ibuilder\Http\Controllers\Api;

use Modules\Core\Icrud\Controllers\BaseCrudController;
use Illuminate\Http\Request;

//Model
use Modules\Ibuilder\Entities\Block;
use Modules\Ibuilder\Repositories\BlockRepository;

class BlockApiController extends BaseCrudController
{
  public $model;
  public $modelRepository;

  public function __construct(Block $model, BlockRepository $modelRepository)
  {
    $this->model = $model;
    $this->modelRepository = $modelRepository;
  }

  /**
   * Organization Index
   */
  public function blockPreview(Request $request)
  {
    $params = $request->all();

    //Instance the blockConfig
    $blockConfig = [
      "component" => json_decode($params['component'] ?? "[]"),
      "entity" => json_decode($params['entity'] ?? "[]"),
      "attributes" => json_decode($params['attributes'] ?? "[]")
    ];

    //Render view
    return view('ibuilder::frontend.blocks', compact('blockConfig'));
  }
}
