<?php

namespace Modules\Ievent\Events\Handlers;

use Modules\Icomments\Events\CommentWasCreated;
use Modules\Ievent\Events\CommentEvent;

class CommentBroadcast
{
    public function handle(CommentWasCreated $event)
    {
        $comment = $event->comment;

        if ($comment->commentable_type == 'Modules\\Ievent\\Entity\\Event') {
            event(new CommentEvent($comment->commentable_id, $comment));
        }
    }
}
