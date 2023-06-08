<?php
namespace Modules\Iplaces\Events\Handlers;

use Modules\Iplaces\Events\PlaceWasCreated;
use Modules\Iplaces\Repositories\PlaceRepository;


class SavePlaceImage
{
    private $place;
    public function __construct(PlaceRepository $place)
    {
        $this->place = $place;
    }
    public function handle(PlaceWasCreated $event)
    {
        $id = $event->entity->id;

        if (!empty($event->data['mainimage'])) {
            $mainimage = saveImage($event->data['mainimage'], "assets/iplaces/place/" . $id . ".jpg");
            if(isset($event->data['options'])){
                $options=(array)$event->data['options'];
            }else{
                $options = array();
            }
            $options["mainimage"] = $mainimage;
            $event->data['options'] = json_encode($options);
        }else{
            $options["mainimage"] = null;
            $event->data['options'] = json_encode($options);
        }
        if (!empty($event->data['gallery']) && !empty($id)) {
            if (count(\Storage::disk('publicmedia')->files('assets/ipaces/pace/gallery/' . $event->data['gallery']))) {
                \File::makeDirectory('assets/ipaces/pace/gallery/' . $id);
                $success = rename('assets/ipaces/pace/gallery/' . $event->data['gallery'], 'assets/ipaces/pace/gallery/' . $id);
            }
        }


        $this->place->update($event->entity, $event->data);
    }

}