<?php

namespace Modules\Menu\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Support\Traits\AuditTrait;
use Modules\Isite\Traits\RevisionableTrait;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;
use TypiCMS\NestableTrait;

class Menuitem extends Model
{
    use Translatable, NestableTrait, BelongsToTenant, AuditTrait, RevisionableTrait;

    public $repository = 'Modules\Menu\Repositories\MenuItemRepository';

    public $translatedAttributes = ['title', 'uri', 'url', 'status', 'locale', 'description'];

    protected $fillable = [
        'menu_id',
        'page_id',
        'system_name',
        'parent_id',
        'position',
        'target',
        'module_name',
        'is_root',
        'icon',
        'link_type',
        'class',
    ];

    protected $table = 'menu__menuitems';

    /**
     * For nested collection
     *
     * @var array
     */
    public $children = [];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    /**
     * Make the current menu item child of the given root item
     */
    public function makeChildOf(Menuitem $rootItem)
    {
        $this->parent_id = $rootItem->id;
        $this->save();
    }

    /**
     * Check if the current menu item is the root
     *
     * @return bool
     */
    public function isRoot(): bool
    {
        return (bool) $this->is_root;
    }

    /**
     * Check if page_id is empty and returning null instead empty string
     *
     * @return number
     */
    public function setPageIdAttribute($value): number
    {
        $this->attributes['page_id'] = ! empty($value) ? $value : null;
    }

    /**
     * Check if parent_id is empty and returning null instead empty string
     *
     * @return number
     */
    public function setParentIdAttribute($value): number
    {
        $this->attributes['parent_id'] = ! empty($value) ? $value : null;
    }

    public function setSystemNameAttribute($value)
    {
        $this->attributes['system_name'] = ! empty($value) ? $value : \Str::slug($this->title, '-');
    }
}
