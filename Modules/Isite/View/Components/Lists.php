<?php

namespace Modules\Isite\View\Components;

use Illuminate\View\Component;

class Lists extends Component
{


    public $items;
    public $view;
    public $itemLayout;
    public $id;
    public $class;
    public $repository;
    public $layout;
    public $title;
    public $subTitle;
    public $params;
    public $margin;
    public $buttonTitle;

    public $titleAlign;
    public $titleColor;
    public $titleVineta;
    public $titleVinetaColor;
    public $titleSize;
    public $titleWeight;
    public $titleTransform;
    public $titleLetterSpacing;
    public $titleLineMarginY;
    public $columnLeft;
    public $columnRight;
    public $orderColumnMain; // 0 - 1
    public $preListContentView;
    public $postListContentView;
    public $emptyItems;
    public $itemComponent;
    public $itemComponentAttributesMain;
    public $itemComponentAttributesList;
    public $itemComponentNamespace;
    public $titleUrl;
    public $titleTarget;
    public $itemComponentAttributes;
    public $titleClasses;
    public $subtitle;
    public $subtitleSize;
    public $subtitleColor;
    public $subtitleWeight;
    public $subtitleTransform;
    public $subtitleLetterSpacing;
    public $subtitleClasses;
    public $textPosition;
    public $textAlign;
    public $columnLayout;
    public $columns;
    public $withLineTitle;
    public $lineTitleConfig;


    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($repository,
                                $class = null,
                                $params = [],
                                $id = 'lists',
                                $buttonTitle = 'Ver Más',
                                $margin = 10,
                                $layout = 'lists-layout-1',
                                $title = "",
                                $subTitle = "",
                                $view = null,
                                $columnLeft = "col-lg-8",
                                $columnRight = "col-lg-4",
                                $orderColumnMain = 0,
                                $preListContentView="",
                                $postListContentView="",
                                $titleAlign = "text-left",
                                $titleLineMarginY= "mt-3 mb-4",
                                $titleColor = null,
                                $titleVineta = null,
                                $titleVinetaColor = null,
                                $titleSize = null,
                                $titleWeight = "font-weight-normal",
                                $titleTransform = null,
                                $titleLetterSpacing = 0,
                                $itemComponent = null,
                                $itemComponentAttributesMain = [],
                                $itemComponentAttributesList = [],
                                $itemComponentNamespace = null,
                                $titleUrl = null,
                                $titleTarget = "_self",
                                $itemLayout = null,
                                $itemComponentAttributes = [],
                                $subtitle = "",
                                $subtitleSize = null,
                                $subtitleWeight = "font-weight-normal",
                                $subtitleTransform = null,
                                $subtitleLetterSpacing = 0,
                                $textPosition = 2,
                                $textAlign = "",
                                $subtitleColor = null,
                                $titleClasses = "",
                                $subtitleClasses = "",
                                $columns = "",
                                $withLineTitle = 0,
                                $lineTitleConfig = []
    )
    {

        $this->id = $id ?? 'itemList';
        $this->margin = $margin;
        $this->repository = $repository;
        $this->params = $params;
        $this->layout = $layout ?? 'item-list-layout-1';
        $this->title = $title;
        $this->subTitle = $subTitle;
        $this->class = $class;
        $this->buttonTitle = $buttonTitle ?? 'Ver más';

        $this->itemLayout = $itemLayout ?? $itemComponentAttributes["itemLayout"] ?? null;
        $this->itemComponent = $itemComponent ?? "isite::item-list";
        $this->view = "isite::frontend.components.lists.layouts.{$this->layout}.index";
        $this->emptyItems = false;
        $this->columnLeft = $columnLeft;
        $this->columnRight = $columnRight;
        $this->orderColumnMain = $orderColumnMain;
        $this->preListContentView  = $preListContentView;
        $this->postListContentView  = $postListContentView;
        $this->titleAlign = $titleAlign;
        $this->titleLineMarginY = $titleLineMarginY;
        $this->titleColor = $titleColor;
        $this->titleVineta = $titleVineta;
        $this->titleVinetaColor = $titleVinetaColor;
        $this->titleSize = $titleSize;
        $this->titleWeight = $titleWeight;
        $this->titleTransform = $titleTransform;
        $this->titleLetterSpacing = $titleLetterSpacing;
        $this->itemComponentNamespace =  $itemComponentNamespace ?? "Modules\Isite\View\Components\ItemList";
        $this->itemComponentAttributesMain = count($itemComponentAttributesMain) ? $itemComponentAttributesMain : config('asgard.isite.config.indexItemListAttributesMain');
        $this->itemComponentAttributesList = count($itemComponentAttributesList) ? $itemComponentAttributesList : config('asgard.isite.config.indexItemListAttributesList');
        $this->itemComponentAttributes = $itemComponentAttributes;
        $this->titleUrl = $titleUrl;
        $this->titleTarget = $titleTarget;
        $this->subtitle = $subtitle;
        $this->subtitleSize = $subtitleSize;
        $this->subtitleWeight = $subtitleWeight;
        $this->subtitleTransform = $subtitleTransform;
        $this->subtitleLetterSpacing = $subtitleLetterSpacing;
        $this->textPosition = $textPosition;
        $this->textAlign = $textAlign;
        $this->subtitleColor = $subtitleColor;
        $this->titleClasses = $titleClasses;
        $this->subtitleClasses = $subtitleClasses;
        $this->columnLayout = explode(",",$columns);
        if($layout=="lists-layout-5" && empty($columns)) {
            $this->columnLayout = [$columnLeft];
        }
        $this->withLineTitle = $withLineTitle;
        $this->lineTitleConfig = !empty($lineTitleConfig) ? $lineTitleConfig : [
            "background" => "var(--primary)",
            "height" => "2px",
            "width" => "10%",
            "margin" => "0 auto"];
        $this->getItems();
    }

    private
    function makeParamsFunction()
    {

        return [
            "include" => $this->params["include"] ?? ['files'],
            "take" => $this->params["take"] ?? 12,
            "page" => $this->params["page"] ?? 1,
            "filter" => $this->params["filter"] ?? [],
            "order" => $this->params["order"] ?? null
        ];
    }

    private
    function getItems()
    {

        $this->items = app($this->repository)->getItemsBy(json_decode(json_encode($this->makeParamsFunction())));
        switch ($this->repository) {
            case 'Modules\Icommerce\Repositories\ProductRepository':
                !$this->itemLayout ? $this->itemLayout = setting('icommerce::productListItemLayout') : false;
                if (is_module_enabled("Icommerce") && $this->itemComponent == "isite::item-list") {
                    $this->itemComponent = "icommerce::product-list-item";
                    $this->itemComponentNamespace = "Modules\Icommerce\View\Components\ProductListItem";
                    $this->itemComponentAttributes["layout"]="product-list-item-layout-1";
                }
                break;
        }
        if ($this->items->isEmpty()) {
            $this->emptyItems = true;
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public
    function render()
    {
        return view($this->view);
    }
}
