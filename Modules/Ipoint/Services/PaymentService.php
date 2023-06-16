<?php

namespace Modules\Ipoint\Services;

use Modules\Ipoint\Entities\Point;
use Modules\Ipoint\Repositories\PointRepository;

class PaymentService
{
    public function __construct(
        PointRepository $point
    ) {
        $this->point = $point;
    }

    /**
     * Get
     *
     * @param    $user Id
     */
    public function getPointsAvailablesForUser($userId)
    {
        $points = 0;
        $points = Point::where('user_id', $userId)->sum('points');

        //\Log::info('Ipoint: Services|getPointsAvailablesForUser|Points: '.$points);

        return $points;
    }

    /**
     * Get
     */
    public function getPointsAllItems($items)
    {
        $totalPoints = 0;
        $itemsValid = true;
        foreach ($items as $item) {
            $points = 0;
            if ($item->product->points > 0) {
                $points = $item->product->points * $item->quantity;
            } else {
                $itemsValid = false;
                break;
            }

            // Sum total
            $totalPoints += $points;
        }

        // Validate all items has points
        if ($itemsValid) {
            return $totalPoints;
        } else {
            return 0;
        }
    }

    /**
     * Validate if process the payment
     */
    public function validateProcessPayment($items, $userId)
    {
        $processPayment = false;

        $pointsItems = $this->getPointsAllItems($items);
        $pointsUser = $this->getPointsAvailablesForUser($userId);

        if ($pointsItems > 0 && $pointsUser >= $pointsItems) {
            $processPayment = true;
        }

        // Response
        return [
            'processPayment' => $processPayment,
            'pointsItems' => $pointsItems,
            'pointsUser' => $pointsUser,
        ];
    }
}
