<?php

namespace Modules\Ibanners\Presenters;

use Illuminate\Support\Facades\View;
use Modules\Ibanners\Entities\Position;

class BannerAdsPresenter extends AbstractAdsPresenter implements BannerAdsPresenterInterface
{
    /**
     * renders slider.
     *
     * @param  string|Position  $position
     * pass Position instance to render specific slider
     * pass string to automatically retrieve slider from repository
     * @param  string  $template blade template to render slider
     * @return string rendered slider HTML
     */
    public function render($position, string $template = 'ibanners::frontend.banners.banner_ads', $options = []): string
    {
        if (! $position instanceof Position) {
            $position = $this->getPositionFromRepository($position);
            if ($position && $position->active == false) {    // inactive slider must not render
                return '';
            }
        }
        if (! $position) {
            return '';
        }

        $view = View::make($template)
            ->with([
                'position' => $position,
                'options' => $options,
            ]);

        return $view->render();
    }

    private function getPositionFromRepository($systemName): Position
    {
        return $this->positionRepository->findBySystemName($systemName);
    }
}
