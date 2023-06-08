<?php
/**
 * Created by PhpStorm.
 * User: imagina
 * Date: 2/10/2018
 * Time: 6:02 PM
 */

namespace Modules\Iplaces\Events\Handlers;

use Modules\Iplaces\Events\CategoryWasCreated;
use Modules\Iplaces\Repositories\CategoryRepository;


class SaveCategoryImage
{
    private $category;

    public function __construct(CategoryRepository $category)
    {
        $this->category = $category;
    }

    public function handle(CategoryWasCreated $event)
    {
        try {
            $id = $event->entity->id;
            if (!empty($event->data['mainimage'])) {
                $mainimage = saveImage($event->data['mainimage'], "assets/iplaces/category/" . $id . ".jpg");
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
            $this->category->update($event->entity, $event->data);
        } catch (\Exception $e) {
            \Log::error($e);

        }
    }


}