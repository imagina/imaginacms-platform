<?php

return [
    'name' => 'Sliders',

    /*
  |--------------------------------------------------------------------------
  | Array of middleware that will be applied on the page module front end routes
  |--------------------------------------------------------------------------
  */
    'middleware' => [],

    'mediaFillable' => [
        'slide' => [
            'slideimage' => 'single',
        ],

    ],
    /*
  |--------------------------------------------------------------------------
  | Define config to owl layout slider-owl-layout-5
  |--------------------------------------------------------------------------
  */
    'indexItemListAttributes' => [
        'layout' => 'item-list-layout-7',
        'mediaImage' => 'slideimage',
        'withImage' => true,
        'withTitle' => true,
        'withSummary' => true,
        'withCategory' => false,
        'withCreatedDate' => false,
        'withViewMoreButton' => true,
        'contentPositionVertical' => 'align-self-center',
        'contentPadding' => 0,
        'contentBorder' => 0,
        'contentBorderColor' => '#dddddd',
        'contentBorderRounded' => 0,
        'contentMarginInsideX' => 'mx-0',
        'contentBorderShadows' => 'none',
        'contentBorderShadowsHover' => '',
        'itemBackgroundColor' => '#ffffff',
        'itemBackgroundColorHover' => '#ffffff',
        'columnLeft' => 'col-lg-6',
        'columnRight' => 'col-lg-6',
        'itemMarginB' => '',
        'contentPaddingLeft' => 15,
        'contentPaddingRight' => 15,
        'contentBorderRoundedType' => '1',
        'imageAspect' => '21/9',
        'imageObject' => 'cover',
        'imageBorderRadio' => 0,
        'imageBorderStyle' => 'solid',
        'imageBorderWidth' => 0,
        'imageBorderColor' => '#000000',
        'imagePadding' => 0,
        'imagePicturePadding' => 0,
        'withImageOpacity' => false,
        'imageOpacityColor' => 'opacity-dark',
        'imageOpacityDirection' => 'opacity-top',
        'imagePosition' => 1,
        'imagePositionVertical' => 'align-self-center',
        'imageBorderRadioType' => '1',
        'imageWidth' => 100,
        'imageAlign' => 'left',
        'buttonMarginT' => 'mt-0',
        'buttonMarginB' => 'mb-0',
        'buttonAlign' => 'text-center',
        'buttonLayout' => 'rounded',
        'buttonIcon' => '',
        'buttonIconLR' => 'left',
        'buttonColor' => 'secondary',
        'viewMoreButtonLabel' => 'isite::common.menu.viewMore',
        'buttonSize' => 'button-normal',
        'buttonTextSize' => 16,
        'titleAlignVertical' => 'align-items-center',
        'numberCharactersTitle' => 200,
        'titleTextDecoration' => 'none',
        'titleHeight' => 'auto',
        'titleMarginT' => 'mt-3',
        'titleMarginB' => 'mb-2',
        'titleAlign' => 'justify-content-center text-center',
        'titleColor' => 'text-primary',
        'titleTextSize' => 20,
        'titleTextWeight' => 'font-weight-bold',
        'titleTextTransform' => '',
        'titleLetterSpacing' => 0,
        'titleVineta' => '',
        'titleVinetaColor' => 'text-dark',
        'summaryAlign' => 'text-center',
        'summaryTextSize' => 16,
        'summaryTextWeight' => 'font-weight-normal',
        'numberCharactersSummary' => 100,
        'summaryLineHeight' => 20,
        'summaryColor' => 'text-white',
        'summaryMarginT' => 'mt-0',
        'summaryMarginB' => 'mb-2',
        'summaryHeight' => 'auto',
        'summaryLetterSpacing' => 0,
        'summaryTextDecoration' => 'none',
        'containerActive' => true,
    ],
    'documentation' => [
        'sliders' => 'slider::cms.documentation.sliders',
    ],
];
