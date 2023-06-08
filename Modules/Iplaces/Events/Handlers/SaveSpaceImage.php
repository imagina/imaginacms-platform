<?php


namespace Modules\Iplaces\Events\Handlers;

use Modules\Iplaces\Repositories\SpaceRepository;
use Modules\Iplaces\Events\SpaceWasCreated;

class SaveSpaceImage
{
    private $space;

    public function __construct(SpaceRepository $space)
    {
        $this->space = $space;
    }

    public function handle(SpaceWasCreated $event)
    {
        try {
            $id = $event->entity->id;
            if (!empty($event->data['mainimage'])) {
                $mainimage = saveImage($event->data['mainimage'], "assets/iplaces/space/" . $id . ".jpg");
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
            $this->space->update($event->entity, $event->data);
        } catch (\Exception $e) {
            \Log::error($e);

        }
    }

}