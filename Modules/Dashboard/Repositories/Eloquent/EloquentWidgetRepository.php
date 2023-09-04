<?php

namespace Modules\Dashboard\Repositories\Eloquent;

use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Modules\Dashboard\Repositories\WidgetRepository;

class EloquentWidgetRepository extends EloquentBaseRepository implements WidgetRepository
{
    /**
     * Find the saved state of widgets for the given user id
     */
    public function findForUser(int $userId): string
    {
        return $this->model->whereUserId($userId)->first();
    }

    /**
     * Update or create the given widgets for given user
     */
    public function updateOrCreateForUser(array $widgets, $userId)
    {
        $widget = $this->findForUser($userId);

        if ($widget) {
            return $this->update($widget, ['widgets' => $widgets]);
        }

        return $this->create(['widgets' => $widgets, 'user_id' => $userId]);
    }
}
