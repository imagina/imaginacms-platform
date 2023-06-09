<?php

namespace Modules\Ibuilder\View\Components;

use Illuminate\View\Component;

class BlockCustom extends Component
{
    public $id;

    public $iconColor;

    public $titleCustom;

    public $titleClasses;

    public $titleSize;

    public $subTitleCustom;

    public $subTitleClasses;

    public $subTitleSize;

    public $summaryCustom;

    public $summaryClasses;

    public $summarySize;

    public $image;

    public $imageOnClasses;

    public $imageInClasses;

    public $imageStyles;

    public $video;

    public $videoClasses;

    public $videoResponsive;

    public $withButton;

    public $buttonClasses;

    public $buttonStyle;

    public $buttonIconClass;

    public $buttonHref;

    public $buttonTarget;

    public $buttonLabel;

    public $buttonAlign;

    public $buttonSizeLabel;

    public $buttonIconPosition;

    public $buttonColor;

    public $buttonLayout;

    public $orderClasses;

    public $mediaClasses;

    public $contentClasses;

    public $gridColumns;

    public $gridGap;

    public $descriptionCustom;

    public $descriptionClasses;

    public $includeCustom;

    public $gallery;

    public $position; /* 1 todo el linea
                         2 dos columnas izq imagen
                         3 dos columas der imagen
                         4 dos columnas izq video
                         5 dos columas der video
                       */

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($id = null,
                                $iconColor = 'currentcolor',
                                $titleCustom = '',
                                $titleClasses = '',
                                $titleSize = '',
                                $subTitleCustom = '',
                                $subTitleClasses = '',
                                $subTitleSize = '',
                                $summaryCustom = '',
                                $summaryClasses = '',
                                $summarySize = '',
                                $image = '',
                                $imageOnClasses = '',
                                $imageInClasses = '',
                                $imageStyles = '',
                                $video = '',
                                $videoClasses = '',
                                $videoResponsive = 'embed-responsive-16by9',
                                $withButton = false,
                                $buttonStyle = '',
                                $buttonClasses = '',
                                $buttonIconClass = '',
                                $buttonHref = '',
                                $buttonTarget = '',
                                $buttonLabel = '',
                                $buttonAlign = '',
                                $buttonSizeLabel = '16',
                                $buttonIconPosition = 'left',
                                $buttonColor = 'primary',
                                $buttonLayout = '',
                                $orderClasses = [],
                                $position = '1',
                                $mediaClasses = '',
                                $contentClasses = '',
                                $gridColumns = 'repeat(2, minmax(0, 1fr))',
                                $gridGap = '15px',
                                $descriptionCustom = '',
                                $descriptionClasses = '',
                                $includeCustom = '',
                                $gallery = []
    ) {
        $this->id = $id ?? uniqid('ac');
        $this->iconColor = $iconColor;
        $this->titleCustom = $titleCustom;
        $this->titleClasses = $titleClasses;
        $this->titleSize = $titleSize;
        $this->subTitleCustom = $subTitleCustom;
        $this->subTitleClasses = $subTitleClasses;
        $this->subTitleSize = $subTitleSize;
        $this->summaryCustom = $summaryCustom;
        $this->summaryClasses = $summaryClasses;
        $this->summarySize = $summarySize;
        $this->image = $image;
        $this->imageOnClasses = $imageOnClasses;
        $this->imageInClasses = $imageInClasses;
        $this->imageStyles = $imageStyles;
        $this->video = $video;
        $this->videoClasses = $videoClasses;
        $this->videoResponsive = $videoResponsive;
        $this->withButton = $withButton;
        $this->buttonClasses = $buttonClasses;
        $this->buttonStyle = $buttonStyle;
        $this->buttonIconClass = $buttonIconClass;
        $this->buttonHref = $buttonHref;
        $this->buttonTarget = $buttonTarget;
        $this->buttonLabel = $buttonLabel;
        $this->buttonAlign = $buttonAlign;
        $this->buttonSizeLabel = $buttonSizeLabel;
        $this->buttonIconPosition = $buttonIconPosition;
        $this->buttonColor = $buttonColor;
        $this->buttonLayout = $buttonLayout;
        $this->orderClasses = ! empty($orderClasses) ? $orderClasses : ['video' => 'order-0', 'image' => 'order-1', 'title' => 'order-2', 'subtitle' => 'order-3', 'summary' => 'order-4', 'description' => 'order-5', 'buttom' => 'order-6', 'include' => 'order-7'];
        $this->position = $position;
        $this->mediaClasses = $mediaClasses;
        $this->contentClasses = $contentClasses;
        $this->gridColumns = $gridColumns;
        $this->gridGap = $gridGap;
        $this->descriptionCustom = $descriptionCustom;
        $this->descriptionClasses = $descriptionClasses;
        $this->includeCustom = $includeCustom;
        $this->gallery = $gallery;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('ibuilder::frontend.components.block-custom');
    }
}
