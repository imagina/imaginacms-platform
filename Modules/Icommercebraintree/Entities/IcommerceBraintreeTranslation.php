<?php

namespace Modules\Icommercebraintree\Entities;

use Illuminate\Database\Eloquent\Model;

class IcommerceBraintreeTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = [];
    protected $table = 'icommercebraintree__icommercebraintree_translations';
}
