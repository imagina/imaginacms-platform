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
     *
     * @param  int  $position
     * @param  array  $item
     */
    private function order(int $position, array $item)
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
     *
     * @param  object  $menuItem
     * @param  int  $position
     */
    private function savePosition(object $menuItem, int $position)
    {
        $this->menuItemRepository->update($menuItem, compact('position'));
    }

    /**
     * Check if the item has children
     *
     * @param  array  $item
     * @return bool
     */
    private function hasChildren(array $item): bool
    {
        return isset($item['children']);
    }

    /**
     * Set the given parent id on the given menu item
     *
     * @param  object  $item
     * @param  int  $parent_id
     */
    private function makeItemChildOf(object $item, int $parent_id)
    {
        $this->menuItemRepository->update($item, compact('parent_id'));
    }

    /**
     * Convert the object to array
     *
     * @return array
     */
    private function convertToArray($data): array
    {
        $data = json_decode(json_encode($data), true);

        return $data;
    }
}
