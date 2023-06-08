<?php

namespace Modules\Icomments\Repositories\Cache;

use Modules\Icomments\Repositories\CommentRepository;
use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;

class CacheCommentDecorator extends BaseCacheCrudDecorator implements CommentRepository
{
    public function __construct(CommentRepository $comment)
    {
        parent::__construct();
        $this->entityName = 'icomments.comments';
        $this->repository = $comment;
    }
}
