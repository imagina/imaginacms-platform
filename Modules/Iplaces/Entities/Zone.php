<?php

namespace Modules\Iplaces\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\PresentableTrait;
use Modules\Core\Support\Traits\AuditTrait;
use Modules\Core\Traits\NamespacedEntity;

class Zone extends Model
{
    use Translatable,PresentableTrait, NamespacedEntity, AuditTrait;

    protected $table = 'iplaces__zones';

    public $translatedAttributes = ['title', 'description'];

    protected $fillable = ['title', 'description', 'options'];

    protected $fakeColumns = ['options'];
    // protected $presenter = CategoryPresenter::class;

    protected $casts = [
        'options' => 'array',
    ];

    /*
     * ---------
     * RELATIONS
     * ---------
     */

    public function places()
    {
        return $this->hasMany(Place::class);
    }

    /*
   |--------------------------------------------------------------------------
   | SCOPES
   |--------------------------------------------------------------------------
   */
    public function scopeFirstLevelItems($query)
    {
        return $query->where('depth', '1')
            ->orWhere('depth', null)
            ->orderBy('lft', 'ASC');
    }

    /**
     * Check if the post is in draft
     *
     * @param  Builder  $query
     * @return Builder
     */
}
