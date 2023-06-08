<?php

namespace Modules\Idocs\Repositories\Cache;

use Modules\Idocs\Repositories\DocumentRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheDocumentDecorator extends BaseCacheDecorator implements DocumentRepository
{
    public function __construct(DocumentRepository $document)
    {
        parent::__construct();
        $this->entityName = 'idocs.documents';
        $this->repository = $document;
    }

    public function getItemsBy($params)
    {
        return $this->remember(function () use ($params) {
            return $this->repository->getItemsBy($params);
        });
    }

    public function getItem($criteria, $params = false)
    {
        return $this->remember(function () use ($criteria, $params) {
            return $this->repository->getItem($criteria, $params);
        });
    }

    /**
     * @param $id
     * @return mixed
     */
    public function whereCategory($id)
    {
        return $this->remember(function () use ($id) {
            return $this->repository->whereCategory($id);
        });
    }
}
