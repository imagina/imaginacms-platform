<?php
/**
 * Created by PhpStorm.
 * User: imagina
 * Date: 16/10/2018
 * Time: 5:11 PM
 */

namespace Modules\Iplaces\Events\Handlers;

use Modules\Iplaces\Repositories\ServiceRepository;
use Modules\Iplaces\Events\ServiceWasCreated;

class SaveServiceImage
{
    private $service;

    public function __construct(ServiceRepository $service)
    {
        $this->service = $service;
    }

    public function handle(ServiceWasCreated $event)
    {
        try {
            $id = $event->entity->id;
            if (!empty($event->data['mainimage'])) {
                $mainimage = saveImage($event->data['mainimage'], "assets/iplaces/service/" . $id . ".jpg");
                if (isset($event->data['options'])) {
                    $options = (array)$event->data['options'];
                } else {
                    $options = array();
                }
                $options["mainimage"] = $mainimage;
                $event->data['options'] = json_encode($options);
                // dd($event);
            } else {
                $event->data['options'] = json_encode($event->data['options']);
            }
            $this->service->update($event->entity, $event->data);
        } catch (\Exception $e) {
            \Log::error($e);

        }
    }

}