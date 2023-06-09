<?php

namespace Modules\Menu\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Support\Traits\AuditTrait;
use Modules\Isite\Entities\Module;
use Modules\Isite\Traits\RevisionableTrait;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class Menu extends Model
{
    use Translatable, BelongsToTenant, AuditTrait, RevisionableTrait;

    public $repository = 'Modules\Menu\Repositories\MenuRepository';

    protected $fillable = [
        'name',
        'title',
        'status',
        'primary',
    ];

    public $translatedAttributes = ['title', 'status'];

    protected $table = 'menu__menus';

    public function menuitems()
    {
        $modulesEnabled = implode('|', Module::where('enabled', 1)->get()->pluck('alias')->toArray() ?? []);

        $relation = $this->hasMany('Modules\Menu\Entities\Menuitem')->with('translations')->orderBy('position', 'asc');
        $relation->whereRaw("system_name REGEXP '$modulesEnabled'");

        return $relation;
    }
}
