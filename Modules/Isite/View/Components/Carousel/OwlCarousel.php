<?php

namespace Modules\Isite\View\Components\Carousel;

use Illuminate\View\Component;

class OwlCarousel extends Component
{
    public $items;

    public $emptyItems;

    public $itemsBySlide;

    public $view;

    public $itemLayout;

    public $loop;

    public $dots;

    public $nav;

    public $center;

    public $navText;

    public $id;

    public $repository;

    public $title;

    public $subTitle;

    public $params;

    public $responsive;

    public $margin;

    public $responsiveClass;

    public $autoplay;

    public $autoplayHoverPause;

    public $containerFluid;

    public $itemComponent;

    public $owlBlockStyle;

    public $editLink;

    public $tooltipEditLink;

    public $autoplayTimeout;

    public $navIcon;

    public $navSizeLabel;

    public $dotsStyle;

    public $navPosition;

    public $owlTextAlign;

    public $navSizeButton;

    public $navStyleButton;

    public $navColor;

    public $owlTextPosition; // 1 -> solo titulo 2 -> titulo con subtitulo debajo 3 -> titulo con subtitilo arria

    public $owlTitleMarginT;

    public $owlTitleMarginB;

    public $owlTitleColor;

    public $owlTitleVineta;

    public $owlTitleVinetaColor;

    public $owlTitleSize;

    public $owlTitleWeight;

    public $owlTitleTransform;

    public $owlTitleLetterSpacing;

    public $owlSubtitleMarginT;

    public $owlSubtitleMarginB;

    public $owlSubtitleColor;

    public $owlSubtitleSize;

    public $owlSubtitleWeight;

    public $owlSubtitleTransform;

    public $owlSubtitleLetterSpacing;

    public $itemComponentAttributes;

    public $itemComponentNamespace;

    public $stagePadding;

    public $owlTitleUrl;

    public $owlTitleTarget;

    public $mouseDrag;

    public $touchDrag;

    public $navOld;

    public $owlWithLineTitle;

    public $owlLineTitleConfig;

    public $owlTitleClasses;

    public $owlSubtitleClasses;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($repository,
                                $id = null,
                                $view = null,
                                $params = [],
                                $margin = 10,
                                $responsiveClass = true,
                                $autoplay = true,
                                $autoplayHoverPause = true,
                                $loop = true,
                                $dots = true,
                                $nav = false,
                                $center = false,
                                $responsive = null,
                                $itemLayout = null,
                                $title = '',
                                $subTitle = '',
                                $itemsBySlide = 1,
                                $navText = '',
                                $containerFluid = false,
                                $itemComponent = null,
                                $owlBlockStyle = null,
                                $navIcon = 'arrow',
                                $owlTextAlign = 'text-left',
                                $navPosition = 'bottom',
                                $navSizeLabel = '20',
                                $dotsStyle = 'dots-linear',
                                $navColor = 'primary',
                                $navSizeButton = '',
                                $navStyleButton = '',
                                $owlTextPosition = 2,
                                $owlTitleMarginT = 'mt-0',
                                $owlTitleMarginB = 'mb-0',
                                $owlTitleColor = null,
                                $owlTitleVineta = null,
                                $owlTitleVinetaColor = null,
                                $owlTitleSize = null,
                                $owlTitleWeight = 'font-weight-normal',
                                $owlTitleTransform = null,
                                $owlTitleLetterSpacing = 0,
                                $owlSubtitleMarginT = 'mt-0',
                                $owlSubtitleMarginB = 'mb-0',
                                $owlSubtitleColor = null,
                                $owlSubtitleSize = null,
                                $owlSubtitleWeight = 'font-weight-normal',
                                $owlSubtitleTransform = null,
                                $owlSubtitleLetterSpacing = 0,
                                $itemComponentAttributes = [],
                                $itemComponentNamespace = null,
                                $stagePadding = 0,
                                $owlTitleUrl = null,
                                $owlTitleTarget = '_self',
                                $autoplayTimeout = 5000,
                                $mouseDrag = true,
                                $touchDrag = true,
                                $navOld = false,
                                $owlWithLineTitle = 0,
                                $owlLineTitleConfig = [],
                                $owlTitleClasses = '',
                                $owlSubtitleClasses = ''
    ) {
        $this->emptyItems = false;
        $this->loop = $loop;
        $this->id = $id ?? uniqid('owlc');
        $this->dots = $dots;
        $this->nav = $nav;
        $this->center = $center;
        $this->navText = json_encode($navText);
        $this->responsive = json_encode($responsive ?? [0 => ['items' => 1], 640 => ['items' => 2], 992 => ['items' => 4]]);
        $this->margin = $margin;
        $this->responsiveClass = $responsiveClass;
        $this->autoplay = $autoplay;
        $this->autoplayHoverPause = $autoplayHoverPause;
        $this->autoplayTimeout = $autoplayTimeout;

        $this->repository = $repository;
        $this->params = $params;
        $this->itemLayout = $itemLayout ?? $itemComponentAttributes['itemLayout'] ?? null;
        $this->title = $title;
        $this->itemsBySlide = $itemsBySlide;
        $this->subTitle = $subTitle;
        $this->containerFluid = $containerFluid;
        $this->owlBlockStyle = $owlBlockStyle;
        $this->itemComponent = $itemComponent ?? 'isite::item-list';
        $this->view = $view ?? 'isite::frontend.components.owl.carousel';
        $this->itemComponentNamespace = $itemComponentNamespace ?? "Modules\Isite\View\Components\ItemList";

        $this->navIcon = $navIcon;
        $this->navSizeLabel = $navSizeLabel;
        $this->dotsStyle = $dotsStyle;
        $this->navPosition = $navPosition;
        $this->navSizeButton = $navSizeButton;
        $this->navStyleButton = $navStyleButton;
        $this->navColor = $navColor;

        $this->owlTextPosition = $owlTextPosition;
        $this->owlTextAlign = $owlTextAlign;
        $this->owlTitleMarginT = $owlTitleMarginT;
        $this->owlTitleMarginB = $owlTitleMarginB;
        $this->owlTitleColor = $owlTitleColor;
        $this->owlTitleVineta = $owlTitleVineta;
        $this->owlTitleVinetaColor = $owlTitleVinetaColor;
        $this->owlTitleSize = $owlTitleSize;
        $this->owlTitleWeight = $owlTitleWeight;
        $this->owlTitleTransform = $owlTitleTransform;
        $this->owlTitleLetterSpacing = $owlTitleLetterSpacing;
        $this->owlSubtitleMarginT = $owlSubtitleMarginT;
        $this->owlSubtitleMarginB = $owlSubtitleMarginB;
        $this->owlSubtitleColor = $owlSubtitleColor;
        $this->owlSubtitleSize = $owlSubtitleSize;
        $this->owlSubtitleWeight = $owlSubtitleWeight;
        $this->owlSubtitleTransform = $owlSubtitleTransform;
        $this->owlSubtitleLetterSpacing = $owlSubtitleLetterSpacing;
        $this->stagePadding = $stagePadding;
        $this->owlTitleUrl = $owlTitleUrl;
        $this->owlTitleTarget = $owlTitleTarget;
        $this->mouseDrag = $mouseDrag;
        $this->touchDrag = $touchDrag;
        $this->itemComponentAttributes = $itemComponentAttributes;
        $this->navOld = $navOld;
        $this->owlTitleClasses = $owlTitleClasses;
        $this->owlSubtitleClasses = $owlSubtitleClasses;
        $this->owlWithLineTitle = $owlWithLineTitle;
        $this->owlLineTitleConfig = ! empty($owlLineTitleConfig) ? $owlLineTitleConfig : [
            'background' => 'var(--primary)',
            'height' => '2px',
            'width' => '10%',
            'margin' => '0 auto'];
        $this->getItems();
        [$this->editLink, $this->tooltipEditLink] = getEditLink($this->repository);
        if ($nav && $navText != '') {
            $this->navOld = true;
            $this->nav = false;
        }
    }

    private function makeParamsFunction()
    {
        return [
            'include' => $this->params['include'] ?? [],
            'take' => $this->params['take'] ?? 12,
            'page' => $this->params['page'] ?? 1,
            'filter' => $this->params['filter'] ?? [],
            'order' => $this->params['order'] ?? null,
        ];
    }

    private function getItems()
    {
        $this->items = app($this->repository)->getItemsBy(json_decode(json_encode($this->makeParamsFunction())));
        switch ($this->repository) {
            case 'Modules\Icommerce\Repositories\ProductRepository':
                ! $this->itemLayout ? $this->itemLayout = setting('icommerce::productListItemLayout') : false;
                if (is_module_enabled('Icommerce') && $this->itemComponent == 'isite::item-list') {
                    $this->itemComponent = 'icommerce::product-list-item';
                    $this->itemComponentNamespace = "Modules\Icommerce\View\Components\ProductListItem";
                    $this->itemComponentAttributes['layout'] = 'product-list-item-layout-1';
                }
                break;
        }

        if (count($this->items) == 1) {
            $this->mouseDrag = false;
            $this->touchDrag = false;
            $this->dots = false;
            $this->nav = false;
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
    public function render()
    {
        return view($this->view);
    }
}
