<?php

namespace Modules\Isite\Entities;

use Astrotomic\Translatable\Translatable;
use Modules\Core\Icrud\Entities\CrudModel;

class Module extends CrudModel
{
    use Translatable;

    protected $table = 'isite__modules';

    public $transformer = 'Modules\Isite\Transformers\ModuleTransformer';

    public $repository = 'Modules\Isite\Repositories\ModuleRepository';

    public $requestValidation = [
        'create' => 'Modules\Isite\Http\Requests\CreateModuleRequest',
        'update' => 'Modules\Isite\Http\Requests\UpdateModuleRequest',
    ];

    //Instance external/internal events to dispatch with extraData
    public $dispatchesEventsWithBindings = [
        //eg. ['path' => 'path/module/event', 'extraData' => [/*...optional*/]]
        'created' => [],
        'creating' => [],
        'updated' => [],
        'updating' => [],
        'deleting' => [],
        'deleted' => [],
    ];

    public $translatedAttributes = [
        'name',
    ];

    protected $fillable = [
        'alias',
        'permissions',
        'settings',
        'crud_fields',
        'deprecated_settings',
        'cms_pages',
        'cms_sidebar',
        'enabled',
        'priority',
        'config',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'permissions' => 'array',
        'settings' => 'array',
        'crud_fields' => 'array',
        'deprecated_settings' => 'array',
        'cms_pages' => 'array',
        'cms_sidebar' => 'array',
        'config' => 'array',
    ];
}
