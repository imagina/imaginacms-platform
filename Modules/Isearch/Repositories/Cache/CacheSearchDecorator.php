<?php

namespace Modules\Isearch\Repositories\Cache;

use Modules\Core\Repositories\Cache\BaseCacheDecorator;
use Modules\Iblog\Entities\Post;
use Modules\Isearch\Repositories\SearchRepository;

class CacheSearchDecorator extends BaseCacheDecorator implements SearchRepository
{
    public function __construct(SearchRepository $search)
    {
        parent::__construct();
        $this->posts = Post::query();
        $this->repository = $search;
    }

    public function whereSearch($searchphrase)
    {
        return $this->posts->where('title', 'LIKE', "%{$searchphrase}%")
            ->orWhere('description', 'LIKE', "%{$searchphrase}%")
            ->orderBy('created_at', 'DESC')->paginate(12);
    }

    public function getRepositoriesFromSetting($params)
    {
        return $this->remember(function () use ($params) {
            return $this->repository->getRepositoriesFromSetting($params);
        });
    }
}
