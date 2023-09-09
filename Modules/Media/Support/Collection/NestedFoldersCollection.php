<?php

namespace Modules\Media\Support\Collection;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection as BaseCollection;

class NestedFoldersCollection extends Collection
{
    private $total;

    private $parentColumn;

    private $removeItemsWithMissingAncestor = true;

    private $indentChars = '&nbsp;&nbsp;&nbsp;&nbsp;';

    public function __construct($items = [])
    {
        parent::__construct($items);
        $this->parentColumn = 'folder_id';
        $this->total = count($items);
    }

    /**
     * Nest items.
     *
     * @return mixed NestableCollection
     */
    public function nest()
    {
        $parentColumn = $this->parentColumn;
        if (! $parentColumn) {
            return $this;
        }
        // Set id as keys.
        $this->items = $this->getDictionary();
        $keysToDelete = [];
        // Add empty collection to each items.
        $collection = $this->each(function ($item) {
            if (! $item->items) {
                $item->items = app(BaseCollection::class);
            }
        });
        // Remove items with missing ancestor.
        if ($this->removeItemsWithMissingAncestor) {
            $collection = $this->reject(function ($item) use ($parentColumn) {
                if ($item->$parentColumn) {
                    $missingAncestor = $this->anAncestorIsMissing($item);

                    return $missingAncestor;
                }
            });
        }
        // Add items to children collection.
        foreach ($collection->items as $key => $item) {
            if ($item->$parentColumn && isset($collection[$item->$parentColumn])) {
                $collection[$item->$parentColumn]->items->push($item);
                $keysToDelete[] = $item->id;
            }
        }
        // Delete moved items.
        $this->items = array_values(Arr::except($collection->items, $keysToDelete));

        return $this;
    }

    /**
     * Recursive function that flatten a nested Collection
     * with characters (default is four spaces).
     *
     * @param  string|boolen|null  $parent_string
     */
    public function listsFlattened(
        string $column = 'title',
        BaseCollection $collection = null,
        int $level = 0,
        array &$flattened = [],
        ?string $indentChars = null,
        $parent_string = null
    ): array {
        $collection = $collection ?: $this;
        $indentChars = $indentChars ?: $this->indentChars;
        foreach ($collection as $item) {
            if ($parent_string) {
                $item_string = ($parent_string === true) ? $item->$column : $parent_string.$indentChars.$item->$column;
            } else {
                $item_string = str_repeat($indentChars, $level).$item->$column;
            }
            $flattened[$item->id] = $item_string;
            if ($item->items) {
                $this->listsFlattened(
                    $column,
                    $item->items,
                    $level + 1,
                    $flattened,
                    $indentChars,
                    ($parent_string) ? $item_string : null
                );
            }
        }

        return $flattened;
    }

    /**
     * Returns a fully qualified version of listsFlattened.
     */
    public function listsFlattenedQualified(
        string $column = 'title',
        BaseCollection $collection = null,
        int $level = 0,
        array &$flattened = [],
        string $indentChars = null
    ): array {
        return $this->listsFlattened($column, $collection, $level, $flattened, $indentChars, true);
    }

    /**
     * Change the default indent characters when flattening lists.
     */
    public function setIndent(string $indentChars)
    {
        $this->indentChars = $indentChars;

        return $this;
    }

    /**
     * Force keeping items that have a missing ancestor.
     */
    public function noCleaning()
    {
        $this->removeItemsWithMissingAncestor = false;

        return $this;
    }

    /**
     * Check if an ancestor is missing.
     */
    public function anAncestorIsMissing($item)
    {
        $parentColumn = $this->parentColumn;
        if (! $item->$parentColumn) {
            return false;
        }
        if (! $this->has($item->$parentColumn)) {
            return true;
        }
        $parent = $this[$item->$parentColumn];

        return $this->anAncestorIsMissing($parent);
    }

    /**
     * Get total items in nested collection.
     */
    public function total()
    {
        return $this->total;
    }

    /**
     * Get total items for laravel 4 compatibility.
     */
    public function getTotal()
    {
        return $this->total();
    }
}
