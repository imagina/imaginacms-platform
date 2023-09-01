<?php

namespace Modules\Slider\Repositories\Eloquent;

use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Modules\Slider\Entities\Slider;
use Modules\Slider\Repositories\SliderRepository;

class EloquentSliderRepository extends EloquentBaseRepository implements SliderRepository
{
    public function create($data)
    {
        $slider = $this->model->create($data);

        return $slider;
    }

    public function update($slider, $data)
    {
        $slider->update($data);

        return $slider;
    }

    /**
     * Count all records
     */
    public function countAll(): int
    {
        return $this->model->count();
    }

    /**
     * Get all available sliders
     */
    public function allOnline(): object
    {
        return $this->model->where('active', '=', true)
          ->orderBy('created_at', 'DESC')
          ->get();
    }

    public function findBySystemName(string $systemName): Slider
    {
        return $this->model->where('system_name', '=', $systemName)->with(['slides', 'slides.files'])->first();
    }
}
