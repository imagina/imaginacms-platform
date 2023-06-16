<?php

namespace Modules\Ibooking\Traits;

/**
 * Trait
 * Used in : Ibooking - Reservation
 */
trait WithItems
{
    /**
     * Boot trait method
     */
    public static function bootWithItems()
    {
        static::updated(function ($model) {
            $model->updateItemsStatus($model);
        });
    }

    public function updateItemsStatus($reservation)
    {
        \Log::info('Ibooking: Traits|WithItems|updateItemsStatus');

        foreach ($reservation->items as $key => $item) {
            $item->status = $reservation->status;
            $item->save();
        }
    }
}
