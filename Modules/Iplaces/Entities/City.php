<?php

namespace Modules\Iplaces\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\NamespacedEntity;
use Modules\Ilocations\Entities\Province;
use Laracasts\Presenter\PresentableTrait;
use Modules\Core\Support\Traits\AuditTrait;

class City extends Model
{
    use Translatable, PresentableTrait, NamespacedEntity, AuditTrait;

    protected $table = 'iplaces__cities';
    public $translatedAttributes = ['title','description'];
    protected $fillable = ['title','description','options','province_id',];
    protected $fakeColumns = ['options'];
    protected $casts = [
        'options' => 'array'
    ];
    public function places()
    {
        return $this->hasMany(Place::class);
    }
    public function province()
    {
        return $this->belongsTo(Province::class);
    }
}
