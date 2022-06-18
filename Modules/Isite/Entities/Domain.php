<?php

namespace Modules\Isite\Entities;

use Astrotomic\Translatable\Translatable;
use Modules\Core\Icrud\Entities\CrudModel;

class Domain extends CrudModel
{
    use Translatable;

    protected $table = 'isite__domains';
    public $transformer = 'Modules\Isite\Transformers\DomainTransformer';
    public $requestValidation = [
        'create' => 'Modules\Isite\Http\Requests\CreateDomainRequest',
        'update' => 'Modules\Isite\Http\Requests\UpdateDomainRequest',
      ];
    public $translatedAttributes = [];
    protected $fillable = [
      'domain',
      'organization_id'
    ];
}
