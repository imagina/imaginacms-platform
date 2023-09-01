<?php

namespace Modules\Iplan\Entities;

use Illuminate\Database\Eloquent\Model;

class SubscriptionRelated extends Model
{
    protected $table = 'iplan__subscriptions_related';

    protected $fillable = [
        'subscription_id',
        'related_type',
        'related_id',
    ];

    public function related()
    {
        return $this->morphTo('related');
    }
}
