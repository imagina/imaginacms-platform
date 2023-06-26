<?php

namespace Modules\Ibanners\Services;

use Illuminate\Support\Facades\URL;

class PositionRenderer
{
    /**
     * @var int Id of the position to render
     */
    protected $positionId;

    /**
     * @var string
     */
    private $startTag = '<div class="dd">';

    /**
     * @var string
     */
    private $endTag = '</div>';

    /**
     * @var string
     */
    private $banners = '';

    public function renderForPosition(Ibanners $position, $banners): string
    {
        $this->positionId = $position->id;

        $this->banners .= $this->startTag;
        $this->generateHtmlFor($banners);
        $this->banners .= $this->endTag;

        return $this->banners;
    }

    /**
     * Generate the html for the given items
     */
    private function generateHtmlFor($banners)
    {
        $this->banners .= '<ol class="dd-list">';
        foreach ($banners as $banner) {
            $this->banners .= "<li class='dd-item' data-id='{$banner->id}'>";
            $editLink = URL::route('dashboard.banner.edit', [$this->positionId, $banner->id]);
            $this->banners .= <<<HTML
<div class="btn-group" role="group" aria-label="Action buttons" style="display: inline">
    <a class="btn btn-sm btn-info" style="float:left;" href="{$editLink}">
        <i class="fa fa-pencil"></i>
    </a>
    <a class="btn btn-sm btn-danger jsDeleteSlide" style="float:left; margin-right: 15px;" data-item-id="{$banner->id}">
       <i class="fa fa-times"></i>
    </a>
</div>
HTML;
            $this->banners .= "<div class='dd-handle'>{$banner->title}</div>";
            if (strpos($banner->getImageUrl(), 'youtube.com')) {
                $this->banners .= "<div><iframe width='100%' height='350' src='".$banner->getImageUrl()."'   frameborder='0' allowfullscreen></iframe></div>";
            } elseif (strpos($banner->getImageUrl(), '.mp4')) {
                $this->banners .= "<div><video class='img-responsive center-block' loop controls='false'>
                        <source src='".$banner->getImageUrl()."' type='video/mp4'>
                    </video></div>";
            } else {
                $this->banners .= "<div><img class='img-responsive' src='".$banner->getImageUrl()."' /></div>";
            }

            $this->banners .= '</li>';
        }
        $this->banners .= '</ol>';
    }
}
