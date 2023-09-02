<?php

namespace Modules\Menu\Services;

use Modules\Menu\Entities\Menuitem;
use Modules\Menu\Repositories\MenuItemRepository;

class MenuOrdener
{
    /**
     * @var MenuItemRepository
     */
    private $menuItemRepository;

    public function __construct(MenuItemRepository $menuItem)
    {
        $this->menuItemRepository = $menuItem;
    }

    public function handle($data)
    {
        $data = $this->convertToArray(json_decode($data));

        foreach ($data as $position => $item) {
            $this->order($position, $item);
        }
    }

    /**
     * Order recursively the menu items
     */
    private function order($position, $item)
    {
        $menuItem = $this->menuItemRepository->find($item['id']);
        if (0 === $position && false === $menuItem->isRoot()) {
            return;
        }
        $this->savePosition($menuItem, $position);
        $this->makeItemChildOf($menuItem, null);

        if ($this->hasChildren($item)) {
            $this->handleChildrenForParent($menuItem, $item['children']);
        }
    }

    private function handleChildrenForParent(Menuitem $parent, array $children)
    {
        foreach ($children as $position => $item) {
            $menuItem = $this->menuItemRepository->find($item['id']);
            $this->savePosition($menuItem, $position);
            $this->makeItemChildOf($menuItem, $parent->id);

            if ($this->hasChildren($item)) {
                $this->handleChildrenForParent($menuItem, $item['children']);
            }
        }
    }

    /**
     * Save the given position on the menu item
     */
    private function savePosition($menuItem, $position)
    {
        $this->menuItemRepository->update($menuItem, compact('position'));
    }

    /**
     * Check if the item has children
     */
    private function hasChildren($item)
    {
        return isset($item['children']);
    }

    /**
     * Set the given parent id on the given menu item
     */
    private function makeItemChildOf($item, $parent_id)
    {
        $this->menuItemRepository->update($item, compact('parent_id'));
    }

    /**
     * Convert the object to array
     */
    private function convertToArray($data)
    {
        $data = json_decode(json_encode($data), true);

        return $data;
    }
}
