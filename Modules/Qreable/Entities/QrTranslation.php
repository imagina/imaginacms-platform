<?php

namespace Modules\Qreable\Entities;

use Illuminate\Database\Eloquent\Model;

class QrTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = [];
    protected $table = 'qreable__qr_translations';
}
