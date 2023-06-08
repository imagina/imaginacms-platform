<?php

namespace Modules\Isite\View\Components;

use Illuminate\View\Component;

class InfoContact extends Component
{
  public $withPhone;
  public $withAddress;
  public $withEmail;
  public $withSocialNetworks;
  public $title;
  public $titlePhone;
  public $titleAddress;
  public $titleEmail;
  public $subtitle;
  public $withTitle;
  public $withSubtitle;
  public $withTitlePhone;
  public $withTitleAddress;
  public $withTitleEmail;
  public $layout;
  public $view;
  public $iconAddress;
  public $iconPhone;
  public $iconEmail;
  public $withIconComponentAddress;
  public $withIconComponentPhone;
  public $withIconComponentEmail;
  public $alignTitle;
  public $alignSubtitle;
  public $alignIcons;
  public $alignTitleInfoContact;
  public $alignInfoContact;
  public $container;
  public $withIconPhone;
  public $withIconAddress;
  public $withIconEmail;
  public $contentBorderType;
  public $contentPaddingY;
  public $contentPaddingX;
  public $contentMarginY;
  public $contentMarginX;
  public $alignSocialNetwork;
  public $layoutSocialNetwork;
  public $colorTitleSection;
  public $fontSizeTitleSection;
  public $colorSubtitleSection;
  public $fontSizeSubtitleSection;
  public $colorTitleContact;
  public $fontSizeTitleContact;
  public $colorIcons;
  public $fontSizeIcons;
  public $orderInfo;
  public $contentBorder;
  public $contentBorderColor;
  public $titlePaddingY;
  public $titlePaddingX;
  public $subtitlePaddingY;
  public $subtitlePaddingX;
  public $iconsPaddingY;
  public $iconsPaddingX;
  public $iconsMarginY;
  public $iconsMarginX;
  public $titleSectionColorByClass;
  public $subtitleSectionColorByClass;
  public $titleContactColorByClass;
  public $contentInline;
  public $displayFlex;
  public $withIconsComponents;
  public $withIcons;
  public $withHyphen;

  /**
   * Create a new component instance.
   *
   * @return void
   */
  public function __construct($withPhone = true, $withAddress = true, $withEmail = true, $withSocialNetworks = true,
                              $title = null, $titlePhone = null, $titleAddress = null, $titleEmail = null,
                              $subtitle = null, $withTitle = true, $withSubtitle = false, $withTitlePhone = true,
                              $withTitleAddress = true, $withTitleEmail = true, $iconAddress = 'fa fa-map-marker',
                              $iconPhone = 'fa fa-phone', $iconEmail = 'fa fa-envelope',
                              $withIconComponentAddress = true, $withIconComponentPhone = true,
                              $withIconComponentEmail = true, $alignTitle = 'text-left', $alignSubtitle = 'text-left',
                              $alignIcons = 'justify-content-left', $alignInfoContact = 'justify-content-left',
                              $alignTitleInfoContact = 'text-left', $container = 'container', $withIconPhone = true,
                              $withIconAddress = true, $withIconEmail = true, $contentBorderType = '',
                              $contentPaddingY = '', $contentPaddingX = '', $contentMarginY = '', $contentMarginX = '',
                              $alignSocialNetwork = 'justify-content-left', $layoutSocialNetwork = 'social-layout-1',
                              $colorTitleSection = '000000FF', $fontSizeTitleSection = '24',
                              $colorTitleContact = '000000FF', $fontSizeTitleContact = '16', $colorIcons = '000000FF',
                              $fontSizeIcons = '16', $orderInfo = [], $contentBorder = '1',
                              $layout = 'info-contact-layout-1', $colorSubtitleSection = '000000FF',
                              $fontSizeSubtitleSection = '16', $contentBorderColor = '000000FF', $titlePaddingY = '',
                              $titlePaddingX = '', $subtitlePaddingY = '', $subtitlePaddingX = '', $iconsPaddingY = '',
                              $iconsPaddingX = '', $iconsMarginY = '', $iconsMarginX = '',
                              $titleSectionColorByClass = 'text-primary', $subtitleSectionColorByClass = 'text-dark',
                              $titleContactColorByClass = 'text-primary', $contentInline = false,
                              $withIconsComponents = true, $withIcons = true, $withHyphen = true
  )
  {
    $this->withPhone = $withPhone;
    $this->withAddress = $withAddress;
    $this->withEmail = $withEmail;
    $this->withSocialNetworks = $withSocialNetworks;
    $this->title = $title ?? trans('isite::common.infoContact.title');
    $this->titlePhone = $titlePhone ?? trans('isite::common.infoContact.titlePhone');
    $this->titleAddress = $titleAddress ?? trans('isite::common.infoContact.titleAddress');
    $this->titleEmail = $titleEmail ?? trans('isite::common.infoContact.titleEmail');
    $this->subtitle = $subtitle;
    $this->withTitle = $withTitle;
    $this->withSubtitle = $withSubtitle;
    $this->withTitlePhone = $withTitlePhone;
    $this->withTitleAddress = $withTitleAddress;
    $this->withTitleEmail = $withTitleEmail;
    $this->iconAddress = $iconAddress;
    $this->iconPhone = $iconPhone;
    $this->iconEmail = $iconEmail;
    $this->withIconPhone = $withIconPhone;
    $this->withIconAddress = $withIconAddress;
    $this->withIconEmail = $withIconEmail;
    $this->withIconComponentAddress = $withIconComponentAddress;
    $this->withIconComponentPhone = $withIconComponentPhone;
    $this->withIconComponentEmail = $withIconComponentEmail;
    $this->alignTitle = $alignTitle;
    $this->alignSubtitle = $alignSubtitle;
    $this->alignTitleInfoContact = $alignTitleInfoContact;
    $this->alignIcons = $alignIcons;
    $this->alignInfoContact = $alignInfoContact;
    $this->container = $container;
    $this->contentBorderType = $contentBorderType;
    $this->contentPaddingY = $contentPaddingY;
    $this->contentPaddingX = $contentPaddingX;
    $this->contentMarginY = $contentMarginY;
    $this->contentMarginX = $contentMarginX;
    $this->alignSocialNetwork = $alignSocialNetwork;
    $this->layoutSocialNetwork = $layoutSocialNetwork;
    $this->colorTitleSection = $colorTitleSection;
    $this->fontSizeTitleSection = $fontSizeTitleSection;
    $this->colorTitleContact = $colorTitleContact;
    $this->fontSizeTitleContact = $fontSizeTitleContact;
    $this->colorIcons = $colorIcons;
    $this->fontSizeIcons = $fontSizeIcons;
    $this->orderInfo = !empty($orderInfo) ? $orderInfo : ["phone" => "order-0", "address" => "order-1", "email" => "order-2", "socialNetworks" => "order-3"];
    $this->colorSubtitleSection = $colorSubtitleSection;
    $this->fontSizeSubtitleSection = $fontSizeSubtitleSection;
    $this->contentBorder = $contentBorder;
    $this->layout = $layout;
    $this->view = "isite::frontend.components.info-contact.layouts." . $this->layout . ".index";
    $this->contentBorderColor = $contentBorderColor;
    $this->titlePaddingY = $titlePaddingY;
    $this->titlePaddingX = $titlePaddingX;
    $this->subtitlePaddingY = $subtitlePaddingY;
    $this->subtitlePaddingX = $subtitlePaddingX;
    $this->iconsPaddingY = $iconsPaddingY;
    $this->iconsPaddingX = $iconsPaddingX;
    $this->iconsMarginY = $iconsMarginY;
    $this->iconsMarginX = $iconsMarginX;
    $this->titleSectionColorByClass = $titleSectionColorByClass;
    $this->subtitleSectionColorByClass = $subtitleSectionColorByClass;
    $this->titleContactColorByClass = $titleContactColorByClass;
    $this->withHyphen = $withHyphen;
    if (!$withIconsComponents){
      $this->withIconComponentAddress = false;
      $this->withIconComponentPhone = false;
      $this->withIconComponentEmail = false;
    }
    if (!$withIcons) {
      $this->withIconPhone = false;
      $this->withIconAddress = false;
      $this->withIconEmail = false;
    }
    if ($contentInline) {
      $this->displayFlex = 'd-flex';
    } else {
      $this->displayFlex = '';
    }
  }

  /**
   * Get the view / contents that represent the component.
   *
   * @return \Illuminate\View\View|string
   */
  public
  function render()
  {
    return view($this->view);
  }
}