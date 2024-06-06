<?php

namespace Modules\Iprofile\Entities;

use Illuminate\Database\Eloquent\Model;

class ProviderAccount extends Model
{

    protected $table = 'iprofile__provider_accounts';
    protected $fillable = ['user_id', 'provider_user_id', 'provider' ,'options'];
    protected $casts = [
        'options'=>'array'
    ];

    protected $fakeColumns = ['options'];

    public function user()
    {
        $driver = config('asgard.user.config.driver');
        return $this->belongsTo("Modules\\User\\Entities\\{$driver}\\User");
    }

}
