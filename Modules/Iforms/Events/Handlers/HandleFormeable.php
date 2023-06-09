<?php

namespace Modules\Iforms\Events\Handlers;

class HandleFormeable
{
    public function handle($event = null)
    {
        $data = $event->data;
        $entity = $event->entity;

        if ($data['form_id']) {
            $entity->forms()->sync([$data['form_id']]);
        } else {
            $entity->forms()->sync([]);
        }
    }
}
