<?php

namespace Modules\Iauctions\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Support\Str;
use Modules\Core\Icrud\Entities\CrudModel;

class Category extends CrudModel
{
    use Translatable;

    protected $table = 'iauctions__categories';

    public $transformer = 'Modules\Iauctions\Transformers\CategoryTransformer';

    public $repository = 'Modules\Iauctions\Repositories\CategoryRepository';

    public $requestValidation = [
        'create' => 'Modules\Iauctions\Http\Requests\CreateCategoryRequest',
        'update' => 'Modules\Iauctions\Http\Requests\UpdateCategoryRequest',
    ];

    public $translatedAttributes = [
        'title',
    ];

    protected $fillable = [
        'system_name',
        'bid_service',
        'options',
        'auction_form_id',
        'bid_form_id',
    ];

    protected $casts = ['options' => 'array'];

    //============== RELATIONS ==============//

    public function auctions()
    {
        return $this->hasMany(Auction::class);
    }

    public function bidForm()
    {
        return $this->belongsTo("Modules\Iforms\Entities\Form", 'bid_form_id');
    }

    //============== MUTATORS / ACCESORS ==============//

    public function setOptionsAttribute($value)
    {
        $this->attributes['options'] = json_encode($value);
    }

    public function setSystemNameAttribute($value)
    {
        if (empty($value) || is_null($value)) {
            $this->attributes['system_name'] = Str::slug($this->title, '-');
        } else {
            $this->attributes['system_name'] = $value;
        }
    }

    public function getOptionsAttribute($value)
    {
        return json_decode($value);
    }
}
