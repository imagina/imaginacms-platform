<?php

namespace Modules\Qreable\Entities;

use Illuminate\Database\Eloquent\Model;

class Qr extends Model
{
    protected $table = 'qreable__qrs';

    protected $fillable = ['code'];

    /**
     * {@inheritdoc}
     */
    public function qreables($model)
    {
        return $this->morphedByMany($model, 'qreable', 'qreable__qred', 'qr_id', 'qreable_id')
            ->withPivot('zone', 'redirect', 'id');
    }

    public function qreablesByZone($model, $zone)
    {
        return $this->morphedByMany($model, 'qreable', 'qreable__qred', 'qr_id', 'qreable_id')
            ->wherePivot('zone', $zone)
            ->withPivot('zone', 'redirect', 'id');
    }
}
