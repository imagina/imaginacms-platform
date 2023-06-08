<?php


namespace Modules\Iplan\Events\Handlers;


class RegisterPlanInProduct
{
    public function handle($event){
        $model = $event->model;
        $entityType = get_class($event->model);
        $data= $event->data;
        if($data['product']) {
            if (is_module_enabled('Icommerce')) {
                $params = json_decode(json_encode(['filter' => ['field' => 'entity_id']]));
                $productWithPlan = app('Modules\\Icommerce\\Repositories\\ProductRepository')->getItem($model->id,$params);
                if($productWithPlan){
                    $productWithPlan->entity_id = 0;
                    $productWithPlan->entity_type = null;
                    $productWithPlan->save();
                }
                $product = app('Modules\\Icommerce\\Repositories\\ProductRepository')->getItem($data['product'], false);
                $product->entity_id = $model->id;
                $product->entity_type = $entityType;
                $product->save();
            }
        }
    }
}
