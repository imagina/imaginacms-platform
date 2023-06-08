<?php

namespace Modules\Igamification\Events\Handlers;

class AddCategoryUser
{

  public function __construct()
  {
  }

  public function handle($event)
  {
    // All params Event
    $params = $event->params;
    $response = $params["data"]["response"] ?? null;
    $requestParams = $params["data"]["requestParams"] ?? [];
    $markAsCompleted = $requestParams->filter->markAsCompleted ?? false;
    $user = \Auth::user();

    if ($response && $markAsCompleted && $user) $response->users()->syncWithoutDetaching($user->id);
  }
}
