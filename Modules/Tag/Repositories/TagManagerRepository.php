<?php

namespace Modules\Tag\Repositories;

use Modules\Tag\Contracts\TaggableInterface;

class TagManagerRepository implements TagManager
{
    /**
     * Array of registered namespaces.
     *
     * @var array
     */
    private $namespaces = [];

    /**
     * Returns all the registered namespaces.
     */
    public function getNamespaces(): array
    {
        return $this->namespaces;
    }

    /**
     * Registers an entity namespace.
     */
    public function registerNamespace(TaggableInterface $entity): void
    {
        $this->namespaces[] = $entity->getEntityNamespace();
    }
}
